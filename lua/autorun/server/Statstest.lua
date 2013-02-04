require( "mysqloo" )
-- Yes this is my DB stuff, Not too bothered about the potential for my emtpy/testing DB to be ruined.
local DATABASE_HOST = "50.116.87.115"
local DATABASE_PORT = 3306
local DATABASE_NAME = "jonzky_sb"
local DATABASE_USERNAME = "jonzky_jonzky"
local DATABASE_PASSWORD = "123spam123"

STATUS_READY    = mysqloo.DATABASE_CONNECTED;
STATUS_WORKING  = mysqloo.DATABASE_CONNECTING;
STATUS_OFFLINE  = mysqloo.DATABASE_NOT_CONNECTED;
STATUS_ERROR    = mysqloo.DATABASE_INTERNAL_ERROR;


function connectToDatabase()

	db = mysqloo.connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT)
	db.onConnected = function() print("[Awesome Stats]******************Database linked!******************************") end
	db.onConnectionFailed = function() print("[Awesome Stats]*****************Failed to connect to the database.******************") end
	db.databaseOnFailure = function(self, err)
		print("[Awesome Stats]Failed to connect to the database: ", err, ". Retrying in 60 seconds.");
		self.automaticretry = true;	
		timer.Simple(60, self.connect, self);
	end
	db:connect()
end
hook.Add( "Initialize", "connectToDatabase111", connectToDatabase ); 
 
 
function checkQuery(query)
    local playerInfo = query:getData()
    if playerInfo[1] ~= nil then
		return true
    else
		return false
    end
end 
 
function loadStats( ply )
	local escpName = db:escape( ply:Nick() )
    local query1 = db:query( "SELECT * FROM ttt_stats WHERE steamid = '" .. ply:SteamID() .. "'")
    query1.onSuccess = function(q)
        if not checkQuery(q) then

			local query2 = db:query("INSERT INTO ttt_stats(steamid, nickname, playtime, roundsplayed, innocenttimes, detectivetimes, traitortimes, deaths, kills, maxfrags) VALUES ('" .. ply:SteamID() .. "', '" .. escpName .. "', '0', '0', '0', '0', '0', '0', '0', '0')")
			query2.onSuccess = function(q)  
			
				print("[Awesome Stats]Created: " .. ply:Nick()) 
				
				ply.plytTime = 0
				ply.roundsplayed = 0
				ply.timesInno = 0
				ply.timesDetective = 0
				ply.timesTraitor = 0
				ply.deaths = 0
				ply.murders = 0
				ply.maxfrags = 0
			
			end
			query2.onError = function(q,e) 
				print("[Awesome Stats]Something went wrong")
				print(e)
			end
			query2:start()
			
        else
			
			print("[Awesome Stats]Loading: " .. ply:Nick())
			--local query3 = db:query("SELECT(playtime, roundsplayed, innocenttimes, detectivetimes, traitortimes, deaths, kills) FROM ttt_stats WHERE steamid = '" .. ply:SteamID() .. "'")
			local query3 = db:query( "SELECT * FROM ttt_stats WHERE steamid = '" .. ply:SteamID() .. "'")
			
			query3.onSuccess = function(q, sdata)
			local row = sdata[1];			
				if (#query3:getData() == 1) then
      
					ply.timesTraitor = row['traitortimes'];
					ply.murders = row['kills'];
					ply.timesInno = row['innocenttimes'];
					ply.deaths = row['deaths'];
					ply.plytTime = row['playtime'];
					ply.timesDetective = row['detectivetimes'];
					ply.roundsplayed = row['roundsplayed'];
					ply.maxfrags = row['maxfrags'];
					ply.timeCheck = CurTime();
  
				end
			end	

			query3.onError = function(q,e)
				print("[Awesome Stats]Something went wrong")
				print(e)
			end
			query3:start()
		end
	end 
	query1.onError = function(q,e)
		print("[Awesome Stats]Something went wrong")
		print(e)
	end
	query1:start()
end

 
local function DeathStat( victim, weapon, killer )
 
	if GAMEMODE.round_state == ROUND_ACTIVE then
		
		if killer:IsValid() and killer.murders != nil then
			if killer:SteamID() != victim:SteamID() then
				killer.murders = killer.murders + 1;
			end
		end		
		victim.deaths = victim.deaths + 1;
		saveStats(victim);
	end	
	
end

local function roundStart()
	for _, ply in pairs(player.GetAll()) do
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

local function roundEnd(result)
	for _, ply in pairs(player.GetAll()) do
		if ply:Alive() then
			saveStats(ply);
		end
		if ply:Frags() > ply.maxfrags then
			ply.maxfrags = ply:Frags();
		end	
	end
end

function saveStats(ply)

	if ply:IsValid() then
		updateString = "UPDATE ttt_stats SET nickname='%s', playtime='%d', roundsplayed='%d', innocenttimes='%d', detectivetimes='%d', traitortimes='%d', deaths='%d', kills='%d', maxfrags='%d' WHERE steamid ='%s'"		
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


function getPlayTime(ply)
	ply.plytTime = (ply.plytTime + (CurTime() - math.Round(ply.timeCheck or CurTime())));	
	ply.timeCheck = CurTime();
	return ply.plytTime
end

function PrintStats(ply, cmd, arg )
	ply:PrintMessage( HUD_PRINTCONSOLE, "Play time " .. (math.Round(getPlayTime(ply)/60)) );
	ply:PrintMessage( HUD_PRINTCONSOLE, "Rounds played " .. ply.roundsplayed );
	ply:PrintMessage( HUD_PRINTCONSOLE, "Inno times " .. ply.timesInno );
	ply:PrintMessage( HUD_PRINTCONSOLE, "Detective Times " .. ply.timesDetective );
	ply:PrintMessage( HUD_PRINTCONSOLE, "Traitor Times " .. ply.timesTraitor );
	ply:PrintMessage( HUD_PRINTCONSOLE, "Deaths " .. ply.deaths );
	ply:PrintMessage( HUD_PRINTCONSOLE, "Kills " .. ply.murders );
	ply:PrintMessage( HUD_PRINTCONSOLE, "High Score " .. ply.maxfrags );
end
concommand.Add( "printStats", PrintStats )

local function pGone( ply )
	saveStats(ply);
end

local function pCome( ply )
	loadStats(ply);
end

-- From Lexic's SB module.
function CheckStatus()
    if (not db or db.automaticretry) then return; end
    local status = db:status();
    if (status == STATUS_WORKING or status == STATUS_READY) then
        return;
    elseif (status == STATUS_ERROR) then
        print("[Awesome Stats]The database object has suffered an inernal error and will be recreated.");
        local pending = db.pending;
        connectToDatabase();
        db.pending = pending;
    else
		print(status);
		db:abortAllQueries();
        print("[Awesome Stats]The server has lost connection to the database. Retrying...")
        db:connect();
    end
end
timer.Create("TTTstatschecker", 60, 0, CheckStatus);

hook.Add( "PlayerInitialSpawn", "playerComes", pCome )
hook.Add( "PlayerDisconnected", "playerGoes", pGone )
hook.Add( "PlayerDeath", "DeathState", DeathStat )
hook.Add( "TTTBeginRound", "bBeginsstats", roundStart)
hook.Add( "TTTEndRound", "endsstats", roundEnd)

