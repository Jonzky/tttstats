local peopleToUpdate = {}

util.AddNetworkString( "Staty" )


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

// Only show !rank to the client who uses it.
rankOnlyClient = true;


function loadPlyStats( ply )


	if not ServerStatsDB.connected then 
		
		timer.Simple( 10, loadServerStats, ply )
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
		ply.ignore_messages = 1;
		ply.dbReady = true;
		ply.points = 0;
		
		return; 
	end
	if not ply:IsValid() then return; end

	local escpName = db:escape( ply:Nick() )
    local tquery1 = db:query( "SELECT * FROM ttt_stats WHERE steamid = '" .. ply:SteamID() .. "'")
    tquery1.onSuccess = function(q)
        if not checkQuery(q) then

			local tquery2 = db:query("INSERT INTO ttt_stats(steamid, nickname, playtime, roundsplayed, innocenttimes, detectivetimes, traitortimes, deaths, kills, maxfrags, headshots, last_seen, isadmin, points, ignore_messages) VALUES ('" .. ply:SteamID() .. "', '" .. escpName .. "', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1')")
			tquery2.onSuccess = function(q)  
			
				notifymessage("[Awesome Stats]Created: " .. ply:Nick()) 
				
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
				ply.ignore_messages = 1;
				ply.dbReady = true;
				ply.points = 0;
			end
			
			tquery2.onError = function(q,e) 
				notifymessage("[Awesome Stats]Something went wrong")
				notifyerror(e)
			end
			tquery2:start()
			
        else
			
			notifymessage("[Awesome Stats]Loading: " .. ply:Nick())
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
					ply.ignore_messages = row['ignore_messages']
					ply.timeCheck = CurTime();
					ply.dbReady = true;
					ply.lKarma = 1000;
					ply.opKills = 0;

  
				end
			end	

			tquery3.onError = function(q,e)
				notifymessage("[Awesome Stats]Something went wrong")
				notifyerror(e)
			end
			tquery3:start()
		end
	end 
	tquery1.onError = function(q,e)
		notifymessage("[Awesome Stats]Something went wrong")
		notifyerror(e)
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

	if not ServerStatsDB.connected then return; end
	
	ply = peopleToUpdate[1];
	table.remove(peopleToUpdate, 1)
	if ply:IsValid() then
	
		if ply:Frags() > ply.maxfrags then
			ply.maxfrags = ply:Frags();
		end	
		if ply:IsAdmin() or ply:CheckGroup("trialadmin") then
			ply.isAdminz = 1
		else
			ply.isAdminz = 0
		end	
		updateString = "UPDATE ttt_stats SET nickname='%s', playtime='%d', roundsplayed='%d', innocenttimes='%d', detectivetimes='%d', traitortimes='%d', deaths='%d', kills='%d', maxfrags='%d', headshots='%d', last_seen='%s', isadmin='%d', points='%d', ignore_messages='%d' WHERE steamid ='%s'"		
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
						tonumber(ply.ignore_messages),
						ply:SteamID()
					)
		
		local updateQuery = db:query(formQ)
		updateQuery.onSuccess = function(q) end; 
		updateQuery.onError = function(q,e)
			notifymessage("[Awesome Stats]Something went wrong")
			notifyerror(e)
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

	if not ServerStatsDB.connected then
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
		notifymessage("[Awesome Stats]Something went wrong")
		notifyerror(e)
	end
	updateQuery:start()

end

function topTen(ply, limit)

	if not ServerStatsDB.connected then
		ply:ChatPrint("The ranking system is currently unavailable :(");
		return
	end
	
	if limit == nil then
		limit = 5
	elseif limit == 1337 then
		limit = 5
	elseif limit > 20 then
		ply:ChatPrint("You cannot view more than 20!")
		limit = 5
	end	
	
	local topTenQ = db:query( "SELECT * FROM ttt_stats ORDER BY points desc LIMIT "..limit.."" )
    topTenQ.onSuccess = function(q, sdata)
		
		if (#sdata == 0) then
			caller:ChatPrint("Something went wrong, if this persists please inform an admin.");
			return
		end	
		
		ply:ChatPrint("Rankings:")
		local pie = 1
		for k,srow in pairs(sdata) do
			
			local toPrint = string.format("(%d) - %s with a score of %d!", pie, srow['nickname'], srow['points']);
			ply:ChatPrint(toPrint);
			
			pie = pie + 1
			
		end

	end
	topTenQ.onError = function(q,e)
		notifymessage("[Awesome Stats]Something went wrong")
		notifyerror(e)
	end
	topTenQ:start();

end

function getRank(ply, caller)

	if not ServerStatsDB.connected then
		caller:ChatPrint("The ranking system is currently unavailable :(");
		return
	end

	local rankCheck = db:query( "SELECT points FROM ttt_stats WHERE steamid ='" .. ply:SteamID() .. "'" )
    rankCheck.onSuccess = function(q, sdata)
		
		if (#sdata != 1) then
			caller:ChatPrint("Something went wrong, if this persists please inform an admin.");
			return
		end	
		row = sdata[1];
		
		local rankStat = db:query( "SELECT COUNT(*) AS allcnt FROM ttt_stats")
		rankStat.onSuccess = function(q, stdata)
			
			countRow = stdata[1];		
			local anRankStat = db:query( "SELECT COUNT(*) AS cnt FROM ttt_stats WHERE points >= '" ..row['points'].. "'")
			anRankStat.onSuccess = function(q, stddata)
				
				RankRow = stddata[1];
				if caller.ignore_messages == 1 or rankOnlyClient then
					caller:ChatPrint(ply:Nick() .. " is currently rank " .. RankRow['cnt'] .. " out of " .. countRow['allcnt'] .. " with a score of " .. row['points'] .. "!"  )
				else
					for k,v in pairs(player.GetAll()) do
						if v.ignore_messages != 1 then 
							v:ChatPrint(ply:Nick() .. " is currently rank " .. RankRow['cnt'] .. " out of " .. countRow['allcnt'] .. " with a score of " .. row['points'] .. "!"  )
						end
					end
				end	
			end
			anRankStat.onError = function(q,e)
				notifymessage("[Awesome Stats]Something went wrong")
				notifyerror(e)
			end
			anRankStat:start()
			
		end
		
		rankStat.onError = function(q,e)
			notifymessage("[Awesome Stats]Something went wrong")
			notifyerror(e)
		end
		rankStat:start()
		
		
	end
	rankCheck.onError = function(q,e)
		notifymessage("[Awesome Stats]Something went wrong")
		notifyerror(e)
	end
	rankCheck:start();

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
		
    elseif tab[1] == "!rank" or tab[1] == "/rank" then
		
		if #tab < 2 then
			getRank(ply,ply)
			return
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
			getRank(rPly,ply)
		else	
			ply:ChatPrint("Player not found!");			
		end
		
		return;
		
	elseif tab[1] == "!stats" or tab[1] == "/stats" then
		
		if #tab < 2 then
			
			print(ply:SteamID64())
			net.Start( "Staty")
				net.WriteEntity(ply)
			net.Send(ply)
			return
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
			net.Start( "Staty")
				net.WriteEntity(rPly)
			net.Send(ply)
		else	
			ply:ChatPrint("Player not found!");			
		end
		
		return;
		
    elseif tab[1] == "!join" then
		ply:SendLua("LocalPlayer():ConCommand('connect "..curServ.."')")

    elseif tab[1] == "!ignore" then
		if ply.ignore_messages == 1 then
			ply:ChatPrint("You are no longer ingorning rank messages");
			ply.ignore_messages = 0;
		else
			ply:ChatPrint("You are now ignoring rank messages")
			ply.ignore_messages = 1;
		end
	elseif tab[1] == "!top" then
		
		if( tonumber(tab[2]) == nil ) then
			topTen(ply,1337)
			return;
		end		
		
		topTen(ply,tonumber(tab[2]))
		
	elseif tab[1] == "!top10" then
		
		topTen(ply,10)
		
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
