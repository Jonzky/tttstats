local lHost = GetConVarString("hostname");

local function adminChecks()
	
	local timeLimit = os.time() - 60;
	
	local adminIssues = db:query( "SELECT * FROM admin_issues WHERE status=0 and start_time > '" .. timeLimit .. "' " )

	adminIssues.onSuccess = function(q, sdata)  
		
		for _, ply in pairs(player.GetAll()) do
			if ply:IsAdmin() then 
				for k,srow in pairs(sdata) do
					local issueString = string.format("[Issue #%d - %s] (%s): %s", srow['id'], srow['server_name'], srow['ply_nick'], srow['ply_message']);
					ply:ChatPrint(issueString)
				end	
			end
		end		
	end
	
	adminIssues.onError = function(q,e) 
		print("[Awesome Issues]Something went wrong")
		print(e)
	end
	adminIssues:start()

end

local function clientShown(id)

	local clientShown = db:query( "UPDATE admin_issues SET status=2, last_update='".. os.time() .."' WHERE id='"..id.."'" )

	clientShown.onSuccess = function(q, sdata) 	
	end
	
	clientShown.onError = function(q,e)
		print("[Awesome Issues]Something went wrong")
		print(e)
	end
	clientShown:start()	

end

local function issueResponse()
		
	local adminIssues = db:query( "SELECT * FROM admin_issues WHERE status=3" )

	adminIssues.onSuccess = function(q, sdata)  
		
		for k,srow in pairs(sdata) do
			for _, ply in pairs(player.GetAll()) do
				if ply:SteamID() == srow['ply_steam'] then
					local issueString = string.format("(Admin Response)[Issue #%d - %s] (%s): %s", srow['id'], srow['server_name'], srow['admin_name'], srow['admin_message']);
					ply:ChatPrint(issueString)
					
					clientShown(srow['id'])
					
				end	
			end
		end		
	end
	
	adminIssues.onError = function(q,e) 
		print("[Awesome Issues]Something went wrong")
		print(e)
	end
	adminIssues:start()

end


local function adminPrint(ply)
	
	
	local timeLimit = os.time() - 600;
	local adminPrint = db:query( "SELECT * FROM admin_issues WHERE status=0 OR start_time > '" .. timeLimit .. "'" )

	adminPrint.onSuccess = function(q, sdata)  
		
		for k,srow in pairs(sdata) do
			
			if srow['status'] == 0 then
				issueString = string.format("(Open)[Issue #%d - %s] (%s): %s", srow['id'], srow['server_name'], srow['ply_nick'], srow['ply_message']);
			elseif srow['status'] == 4 then						
				issueString = string.format("(Closed)[Issue #%d - %s] (%s): %s", srow['id'], srow['server_name'], srow['ply_nick'], srow['ply_message']);
			elseif srow['status'] == (2 or 3) then			
				issueString = string.format("(Admin Accepeted)[Issue #%d - %s] (%s): %s", srow['id'], srow['server_name'], srow['ply_nick'], srow['ply_message']);
			elseif srow['status'] == 5 then			
				issueString = string.format("(Expired)[Issue #%d - %s] (%s): %s", srow['id'], srow['server_name'], srow['ply_nick'], srow['ply_message']);
			end
			ply:ChatPrint(issueString)
			
			
			if srow['admin_message'] != "" then
				local issueString = string.format("(Admin Response)[Issue #%d - %s] (%s): %s", srow['id'], srow['server_name'], srow['admin_name'], srow['admin_message']);
				ply:ChatPrint(issueString)

			end

		end	
		
		if #sdata == 0 then
			ply:ChatPrint("No open issues at the moment!")
		end
	end
	
	adminPrint.onError = function(q,e) 
		print("[Awesome Issues]Something went wrong")
		print(e)
	end
	adminPrint:start()

end


local function gotoIssue(ply, id)
		
	local gotoIssue = db:query( "SELECT server_ip FROM admin_issues WHERE id='" .. id .. "' " )

	gotoIssue.onSuccess = function(q, sdata)  
		if #sdata == 0 then
			ply:ChatPrint("Issue not found")
		else
			rows = sdata[1]	
			ply:SendLua("LocalPlayer():ConCommand('connect "..rows['server_ip'].."')")
		end	
	

	end
	
	gotoIssue.onError = function(q,e) 
		print("[Awesome Issues]Something went wrong")
		print(e)
	end
	gotoIssue:start()

end

local function updateIssue(ply, id, text)

	local adminEscp = db:escape( ply:Nick() );
	local escpMessage = db:escape( text );

	local updateME = "UPDATE admin_issues SET status='%d', last_update='%d', admin_name='%s', admin_steam='%s', admin_message='%s' WHERE id='%d'"		
	local formQ = string.format(updateME,
					3,
					os.time(),
					adminEscp,
					ply:SteamID(),
					escpMessage,
					id
				)
	
	local updateIssue = db:query(formQ)

	updateIssue.onSuccess = function(q, sdata) 	
		if updateIssue:affectedRows() == 0 then
			ply:ChatPrint("No issue found")
		else
			ply:ChatPrint("The issue has been updated.")
		end	
	end
	
	updateIssue.onError = function(q,e)
		print("[Awesome Issues]Something went wrong")
		print(e)
	end
	updateIssue:start()	


end

local function closeIssue(ply, id)


	local closeMe = "UPDATE admin_issues SET status='%d', last_update='%d' WHERE id='%d'"		
	local formQ = string.format(closeMe,
					4,
					os.time(),
					id
				)
	
	local closeIssue = db:query(formQ)

	closeIssue.onSuccess = function(q, sdata) 	
		if closeIssue:affectedRows() == 0 then
			ply:ChatPrint("No issue found")
		else
			ply:ChatPrint("The issue has been closed.")
		end
	end
	
	closeIssue.onError = function(q,e)
		print("[Awesome Issues]Something went wrong")
		print(e)
	end
	closeIssue:start()	


end

local function maintainIssues()

	-- Time before an issue is marked as 'expired' in seconds.	
	local timeLimit = os.time() - 600;
	
	if databaseFailed then return; end

	local maintainMe = "UPDATE admin_issues SET status='%d', last_update='%d' WHERE status ='%d' AND start_time <'%d'"		
	local formQ = string.format(maintainMe,
					5,
					os.time(),
					0,
					timeLimit
				)
	
	local maintainIssues = db:query(formQ)
	maintainIssues.onSuccess = function(q) end; 
	maintainIssues.onError = function(q,e)
		print("[Awesome Tracker]Something went wrong")
		print(e)
	end
	maintainIssues:start()	
	
end

local function checkIssues()

	if not ServerStatsDB.connected then return; end

	local adminHere = false;	
	for _, ply in pairs(player.GetAll()) do
		if ply:IsAdmin() then adminHere = true; end
	end 
		
	if adminHere then
		adminChecks();
	end	
	
	issueResponse()
	maintainIssues();

end

timer.Create("IssueChecker", 40, 0, checkIssues);



local function fileReport(ply, tabl)

	if not ServerStatsDB.connected then
		repName:ChatPrint("Something went wrong and the player wasn't reported :(");
		return
	end

	ipPort = string.format("%s:%s", ServerStatsDB.ServerIP, ServerStatsDB.ServerPort);

	reportMessage = db:escape( tabl );
	issueStr = "INSERT INTO admin_issues(ply_nick, ply_steam, ply_message, start_time, last_update, status, server_name, server_ip) VALUES ('%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s')"
	local issueReporter = db:escape( ply:Nick() );
	local formQ = string.format(issueStr,
					issueReporter,
					ply:SteamID(),
					reportMessage,
					os.time(),
					os.time(),
					0,
					GetConVarString("hostname"),
					ipPort
				)
	
	print(formQ)
	local issueCreateQ = db:query(formQ)

	issueCreateQ.onSuccess = function(q)  
		local issueNumber = issueCreateQ:lastInsert();
		ply:ChatPrint("Issue reported! Your reference number is: " .. issueNumber );
	end
	
	issueCreateQ.onError = function(q,e) 
		ply:ChatPrint("Something went wrong and the issue wansn't filed :(");
		print("[Awesome Stats]Something went wrong")
		print(e)
	end
	issueCreateQ:start()
end



local function issueCom( ply, text, toall )

	local tLen = string.len(text);

	alFound = false;
	rPly = nil;
    local tab = string.Explode( " ", text );
	if tab[1] == "!issue" or tab[1] == "/issue" then
		
		if #tab < 2 then
			ply:ChatPrint("You need to leave a message!");
			return false
		end	
		
		lenName = (string.len(tab[2]) + 10);

		local rest = string.sub(text,8,tLen)

		fileReport(ply, rest)
		
		return false
		
	elseif tab[1] == "!update" or tab[1] == "/update" then
	
		print(type(tab[2]))
		if( tonumber(tab[2]) == nil ) then
			ply:ChatPrint("Thats some crazy ID you typed in, try again.");
			return			
		end

		if not ply:IsAdmin() then
			ply:ChatPrint("Your not an admin.. You tard.")
			return
		end
		
		if #tab < 3 then
			ply:ChatPrint("You need to leave a message/ID!");
			return;
		end
		
		lenName = (string.len(tab[2]) + 10);
		
		local Rest = string.sub(text,lenName,tLen);

		updateIssue(ply, tab[2], Rest);

		return false

	
	elseif tab[1] == ("!close" or "/close") then
	
		if( tonumber(tab[2]) == nil ) then
			ply:ChatPrint("Thats some crazy ID you typed in, try again.");
			return			
		end		

		if not ply:IsAdmin() then
			ply:ChatPrint("Your not an admin.. You tard.");
			return
		end		
	
		if #tab < 2 then
			ply:ChatPrint("You need to leave a message/ID!");
			return
		end
	
		closeIssue(ply, tab[2]);

		return false

				
	elseif tab[1] == ("!ajoin" or "/ajoin") then

		if( tonumber(tab[2]) == nil ) then
			ply:ChatPrint("Thats some crazy ID you typed in, try again.");
			return			
		end		

		if not ply:IsAdmin() then
			ply:ChatPrint("Your not an admin.. You tard.");
			return
		end			
	
		gotoIssue(ply,tab[2])

		return false
	
	
	elseif tab[1] == ("!ashow" or "/ashow") then

		if not ply:IsAdmin() then
			ply:ChatPrint("Your not an admin.. You tard.");
			return
		end		
		adminPrint(ply)
		return false

	end	
end

hook.Add( "PlayerSay", "Issue commands", issueCom)

