local peopleToUpdate = {}

--- Scores for killing
Inno_Kill_T = 5;
Inno_Kill_Inno = -10;
Inno_Kill_D = -20;
T_Kill_Inno = 5;
T_Kill_D = 10;
T_Kill_T = -20;
D_Kill_T = 5;
D_Kill_Inno = -5;
D_Kill_D = -20;
Surviving_the_Round = 2;
death = -1;


function loadPlyStats( ply )

	if databaseFailed then return; end
	if not ply:IsValid() then return; end

	local escpName = db:escape( ply:Nick() )
    local tquery1 = db:query( "SELECT * FROM ttt_stats WHERE steamid = '" .. ply:SteamID() .. "'")
    tquery1.onSuccess = function(q)
        if not checkQuery(q) then

			local tquery2 = db:query("INSERT INTO ttt_stats(steamid, nickname, playtime, roundsplayed, innocenttimes, detectivetimes, traitortimes, deaths, kills, maxfrags, headshots, last_seen, isadmin, points) VALUES ('" .. ply:SteamID() .. "', '" .. escpName .. "', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')")
			tquery2.onSuccess = function(q)  
			
				print("[Awesome Stats]Created: " .. ply:Nick()) 
				
				ply.plytTime = 0;
				ply.roundsplayed = 0;
				ply.timesInno = 0;
				ply.timesDetective = 0;
				ply.timesTraitor = 0;
				ply.deaths = 0;
				ply.murders = 0;
				ply.maxfrags = 0;
				ply.headshots = 0;
				ply.opKills = 0;
				ply.dbReady = true;
				ply.points = 0;
			end
			
			tquery2.onError = function(q,e) 
				print("[Awesome Stats]Something went wrong")
				print(e)
			end
			tquery2:start()
			
        else
			
			print("[Awesome Stats]Loading: " .. ply:Nick())
			local tquery3 = db:query( "SELECT * FROM ttt_stats WHERE steamid = '" .. ply:SteamID() .. "'")
			
			tquery3.onSuccess = function(q, sdata)
			local row = sdata[1];			
				if (#tquery3:getData() == 1) then
      
					ply.timesTraitor = row['traitortimes'];
					ply.murders = row['kills'];
					ply.timesInno = row['innocenttimes'];
					ply.deaths = row['deaths'];
					ply.plytTime = row['playtime'];
					ply.timesDetective = row['detectivetimes'];
					ply.roundsplayed = row['roundsplayed'];
					ply.maxfrags = row['maxfrags'];
					ply.headshots = row['headshots'];
					ply.points = row['points'];
					ply.timeCheck = CurTime();
					ply.dbReady = true;
					ply.lKarma = 1000;
					ply.opKills = 0;

  
				end
			end	

			tquery3.onError = function(q,e)
				print("[Awesome Stats]Something went wrong")
				print(e)
			end
			tquery3:start()
		end
	end 
	tquery1.onError = function(q,e)
		print("[Awesome Stats]Something went wrong")
		print(e)
	end
	tquery1:start()
end

 
local function DeathStat( victim, weapon, killer )
 
	if GAMEMODE.round_state == ROUND_ACTIVE then
		if killer:IsValid() and killer.dbReady and killer.murders != nil then
			if killer:SteamID() != victim:SteamID() then
				if victim.lastHitGroup && victim.lastHitGroup == HITGROUP_HEAD then
					killer.headshots = killer.headshots + 1;
				end
				
				
				-- Bellow are 'rdm' kills.
				if killer:GetTraitor() == victim:GetTraitor() then
				
					if killer:GetTraitor() then
						killer.points = killer.points + T_Kill_T;
					elseif killer:GetDetective() and victim:GetDetective() then
						killer.points = killer.points + D_Kill_D;
					elseif killer:GetDetective() then
						killer.points = killer.points + D_Kill_Inno;
					elseif not (killer:GetTraitor() or killer:GetDetective()) and not (victim:GetTraitor() or victim:GetDetective()) then
						killer.points = killer.points + Inno_Kill_Inno;
					elseif not (killer:GetTraitor() or killer:GetDetective()) then
						killer.points = killer.points + Inno_Kill_D;
					end		

					
					killer.opKills = killer.opKills + 1;
				-- These are 'legitimate' kills
				else
					
					if killer:GetTraitor() and victim:GetDetective() then
						killer.points = killer.points + T_Kill_D;
					elseif killer:GetTraitor() then
						killer.points = killer.points + T_Kill_Inno;
					elseif killer:GetDetective() then
						killer.points = killer.points + D_Kill_T;
					elseif not (killer:GetTraitor() or killer:GetDetective()) then
						killer.points = killer.points + Inno_Kill_T;
					end	
				
					killer.murders = killer.murders + 1;
				end
			end
		end	
				
		if not victim.dbReady then return; end
		victim.deaths = victim.deaths + 1;
		savePlyStats(victim);
	end	
	
end

local function roundStart()
	for _, ply in pairs(player.GetAll()) do
		if ply.dbReady then
			if ply:IsTraitor() then
				ply.timesTraitor = ply.timesTraitor + 1;
			elseif ply:IsDetective() then
				ply.timesDetective = ply.timesDetective + 1;
			else
				ply.timesInno = ply.timesInno + 1;
			end	
			ply.roundsplayed = ply.roundsplayed + 1;
		end	
	end	
end

local function roundEnd(result)
	for _, ply in pairs(player.GetAll()) do
		if ply.dbReady then
			if ply:Alive() then
				ply.points = ply.points + Surviving_the_Round; 
			else
				ply.points = ply.points + death; 
			end
			if ply:Frags() > ply.maxfrags or ply:Alive() then
				savePlyStats(ply);
			end
		end
	end	
end

function savePlyStats(ply)
	
	if table.HasValue( peopleToUpdate, ply ) then return; end
	table.insert( peopleToUpdate, ply);

end

function savePlyStatsSQL()

	if #peopleToUpdate == 0 then return; end

	if databaseFailed then return; end
	
	ply = peopleToUpdate[1];
	table.remove(peopleToUpdate, 1)
	if ply:IsValid() then
	
		if ply:Frags() > ply.maxfrags then
			ply.maxfrags = ply:Frags();
		end	
		if ply:IsAdmin() then
			ply.isAdminz = 1
		else
			ply.isAdminz = 0
		end	
		updateString = "UPDATE ttt_stats SET nickname='%s', playtime='%d', roundsplayed='%d', innocenttimes='%d', detectivetimes='%d', traitortimes='%d', deaths='%d', kills='%d', maxfrags='%d', headshots='%d', last_seen='%s', isadmin='%d', points='%d' WHERE steamid ='%s'"		
		local EcName = db:escape( ply:Nick() );		
		local formQ = string.format(updateString,
						EcName,
						tonumber(getPlayTime(ply)),
						tonumber(ply.roundsplayed),
						tonumber(ply.timesInno),
						tonumber(ply.timesDetective),
						tonumber(ply.timesTraitor),
						tonumber(ply.deaths),
						tonumber(ply.murders),
						tonumber(ply.maxfrags),
						tonumber(ply.headshots),
						tostring(os.date()),
						tonumber(ply.isAdminz),
						tonumber(ply.points),
						ply:SteamID()
					)
		
		--print(formQ)
		local updateQuery = db:query(formQ)
		updateQuery.onSuccess = function(q) end; 
		updateQuery.onError = function(q,e)
			print("[Awesome Stats]Something went wrong")
			print(e)
		end
		updateQuery:start()	
	
	end
end
timer.Create("StatsUpdater", 1, 0, savePlyStatsSQL);

function getPlayTime(ply)
	ply.plytTime = (ply.plytTime + (CurTime() - math.Round(ply.timeCheck or CurTime())));	
	ply.timeCheck = CurTime();
	return ply.plytTime
end

function PrintStats(ply, cmd, arg )
	if ply.dbReady then
	
		ply:PrintMessage( HUD_PRINTCONSOLE, "Time played: " .. (math.Round(getPlayTime(ply)/60)) );
		ply:PrintMessage( HUD_PRINTCONSOLE, "Score: " .. ply.points );
		ply:PrintMessage( HUD_PRINTCONSOLE, "Rounds played: " .. ply.roundsplayed );
		ply:PrintMessage( HUD_PRINTCONSOLE, "Innocent times: " .. ply.timesInno );
		ply:PrintMessage( HUD_PRINTCONSOLE, "Detective Times: " .. ply.timesDetective );
		ply:PrintMessage( HUD_PRINTCONSOLE, "Traitor Times: " .. ply.timesTraitor );
		ply:PrintMessage( HUD_PRINTCONSOLE, "Deaths: " .. ply.deaths );
		ply:PrintMessage( HUD_PRINTCONSOLE, "Kills: " .. ply.murders );
		ply:PrintMessage( HUD_PRINTCONSOLE, "Headshots: " .. ply.headshots );
		ply:PrintMessage( HUD_PRINTCONSOLE, "High Score: " .. ply.maxfrags );
	else
		ply:PrintMessage( HUD_PRINTCONSOLE, "An error has occured please rejoin in order to be tracked" );

	end
end
concommand.Add( "printStats", PrintStats )

local function pGone( ply )
	if ply.dbReady then
		savePlyStats(ply);
	end	
end

local function pCome( ply )
	ply.dbReady = false
	loadPlyStats(ply);
end


local function reportPlayer(ply, tabl, repName)

	if databaseFailed then
		repName:ChatPrint("Something went wrong and the player wasn't reported :(");
		return
	end

	if ply.lKarma > ply:GetLiveKarma() then
		ply.lKarma = ply:GetLiveKarma()
	end	

--	reportM = table.concat(tabl," ",3,#tabl); 
	reportMessage = db:escape( tabl );
	RepString = "INSERT INTO ttt_report(steamid, nickname, lKarma, opKills, message, repID, repNick) VALUES ('%s', '%s', '%d', '%d', '%s', '%s', '%s')"
	local badBoy = db:escape( ply:Nick() );
	local ecName = db:escape( repName:Nick() );
	local formQ = string.format(RepString,
					ply:SteamID(),
					badBoy,
					tonumber(ply.lKarma),
					tonumber(ply.opKills),
					reportMessage,
					repName:SteamID(),
					ecName
				)
	
	local updateQuery = db:query(formQ)

	updateQuery.onSuccess = function(q)  
	
		repName:ChatPrint("Player reported! Thanks for the report.");
	
	end
	
	updateQuery.onError = function(q,e) 
		repName:ChatPrint("Something went wrong and the player wasn't reported :(");
		print("[Awesome Stats]Something went wrong")
		print(e)
	end
	updateQuery:start()

end

local function repCom( ply, text, toall )

	local tLen = string.len(text);

	alFound = false;
	rPly = nil;
	
	
    local tab = string.Explode( " ", text );
    if tab[1] == "!report" or tab[1] == "/report" then
		
		if #tab < 3 then
			ply:ChatPrint("You need to leave a message and/or player!");
			return false
		end
			
		for k,v in pairs(player.GetAll()) do
			
			if string.find(string.lower(v:Nick()),string.lower(tab[2])) then

				if alFound then
					ply:ChatPrint("Two 2 or more players found with that name")
					return
				end
				
				alFound = true;
				rPly = v;
			end	
		end
		
		if alFound then
		
			lName = rPly:Nick();
			lenName = (string.len(tab[2]) + 10);
			local Rest = string.sub(text,lenName,tLen)
			reportPlayer(rPly, Rest, ply);
		else	
			ply:ChatPrint("Player not found!");			
		end
		
		return false;
    elseif tab[1] == "!join" then
		ply:SendLua("LocalPlayer():ConCommand('connect "..curServ.."')")
	end
 
end
hook.Add( "PlayerSay", "ReportCommands", repCom)

hook.Add( "PlayerInitialSpawn", "playerComes", pCome )
hook.Add( "PlayerDisconnected", "playerGoes", pGone )
hook.Add( "PlayerDeath", "DeathState", DeathStat )
hook.Add( "TTTBeginRound", "bBeginsstats", roundStart)
hook.Add( "TTTEndRound", "endsstats", roundEnd)

hook.Add("ScalePlayerDamage", "ScalePlayerDamage.Headshot", function(plp, hitGroup)
    plp.lastHitGroup = hitGroup
end)
