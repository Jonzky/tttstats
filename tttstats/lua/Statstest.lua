local peopleToUpdate = {}

function loadPlyStats( ply )

	if databaseFailed then return; end
	if not ply:IsValid() then return; end

	local escpName = db:escape( ply:Nick() )
    local tquery1 = db:query( "SELECT * FROM ttt_stats WHERE steamid = '" .. ply:SteamID() .. "'")
    tquery1.onSuccess = function(q)
        if not checkQuery(q) then

			local tquery2 = db:query("INSERT INTO ttt_stats(steamid, nickname, playtime, roundsplayed, innocenttimes, detectivetimes, traitortimes, deaths, kills, maxfrags, headshots, last_seen, isadmin) VALUES ('" .. ply:SteamID() .. "', '" .. escpName .. "', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')")
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
				ply.dbReady = true;			
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
					ply.timeCheck = CurTime();
					ply.dbReady = true;

  
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
				killer.murders = killer.murders + 1;
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
		updateString = "UPDATE ttt_stats SET nickname='%s', playtime='%d', roundsplayed='%d', innocenttimes='%d', detectivetimes='%d', traitortimes='%d', deaths='%d', kills='%d', maxfrags='%d', headshots='%d', last_seen='%s', isadmin='%d' WHERE steamid ='%s'"		
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
	loadPlyStats(ply);
end

hook.Add( "PlayerInitialSpawn", "playerComes", pCome )
hook.Add( "PlayerDisconnected", "playerGoes", pGone )
hook.Add( "PlayerDeath", "DeathState", DeathStat )
hook.Add( "TTTBeginRound", "bBeginsstats", roundStart)
hook.Add( "TTTEndRound", "endsstats", roundEnd)

hook.Add("ScalePlayerDamage", "ScalePlayerDamage.Headshot", function(plp, hitGroup)
    plp.lastHitGroup = hitGroup
end)
