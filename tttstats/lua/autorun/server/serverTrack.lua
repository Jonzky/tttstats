require( "mysqloo" )
util.AddNetworkString( "TESTY" )
AddCSLuaFile( "cl_dermastuff.lua" )
include( "cl_dermastuff.lua" )


---- UPDATE ME
local SERVER_IP = "localhost"
local SERVER_PORT = 27015
local MAX_PLAYERS = 18

STATUS_READY    = mysqloo.DATABASE_CONNECTED;
STATUS_WORKING  = mysqloo.DATABASE_CONNECTING;
STATUS_OFFLINE  = mysqloo.DATABASE_NOT_CONNECTED;
STATUS_ERROR    = mysqloo.DATABASE_INTERNAL_ERROR;

function getPlyCount()

	local i = 0;
	for k,v in pairs(player.GetAll()) do
		i = i + 1;
	end
	return i;

end

function loadServerStats( )

	lHost = GetConVarString("hostname");
	ipPort = string.format("%s:%s", SERVER_IP, SERVER_PORT);
	currentMap = game.GetMap();

    local Statquery1 = db:query("SELECT * FROM server_track WHERE hostip = '" .. ipPort .. "'")
	    
	Statquery1.onError = function(q,e)
		print("[Awesome Tracker]Something went wrong")
		print(e)
	end
	
	Statquery1.onSuccess = function(q)
        if not checkQuery(q) then

			local Statquery2 = db:query("INSERT INTO server_track(hostip, hostname, maxplayers, map, players, lastupdate) VALUES ('" .. ipPort .. "', '" .. lHost .. "', '" .. MAX_PLAYERS .. "', '" .. currentMap .. "', '" .. getPlyCount() .. "', '" .. os.time() .. "')")

			Statquery2.onSuccess = function(q)  
			
				print("[Awesome Tracker]Added this server to the table!") 
				
				playerCount = getPlyCount();
				
			end
			Statquery2.onError = function(q,e) 
				print("[Awesome Tracker]Something went wrong")
				print(e)
			end
			Statquery2:start()
		end	
		updateReady = true
	end 
	Statquery1:start()

	
end


function updateServers ()
	
	if not updateReady then return; end
	if databaseFailed then return; end

	updateString = "UPDATE server_track SET hostname='%s', maxplayers='%d', map='%s', players='%d', lastupdate='%d' WHERE hostip ='%s'"		
	local formQ = string.format(updateString,
					GetConVarString("hostname"),
					MAX_PLAYERS,
					game.GetMap(),
					getPlyCount(),
					os.time(),
					ipPort
				)
	
	local updateQuery = db:query(formQ)
	updateQuery.onSuccess = function(q) end; 
	updateQuery.onError = function(q,e)
		print("[Awesome Tracker]Something went wrong")
		print(e)
	end
	updateQuery:start()	

end
timer.Create("serverUpdater", 15, 0, updateServers);


function getServers(ply)

	if databaseFailed then
		ply:PrintMessage( HUD_PRINTTALK, "The server browser is currently unavailable - please try again soon");
		return
	end	
	
	local getAllQ = db:query( "SELECT * FROM server_track")
    getAllQ.onSuccess = function(q, sdata)
		net.Start( "TESTY")
			net.WriteTable(sdata)
			net.WriteFloat(os.time())
		net.Send(ply)
	end
	getAllQ.onError = function(q,e)
		print("[Awesome Tracker]Something went wrong")
		print(e)
	end
	getAllQ:start()
end

local adverts = {
"To view the server browser type /servers in chat!",
"Want to play a different gamemode? Type /servers in chat!"
}

function superAd()
	for k,v in pairs(player.GetAll()) do
		v:ChatPrint(tostring(table.Random(adverts)))
	end
end
timer.Create( "SuperADD", 120, 0, superAd)

local function chatCom( ply, text, toall )

    local tab = string.Explode( " ", text );
    if tab[1] == "!servers" or tab[1] == "/servers" then
     
        getServers(ply)
     
    end
 
end
hook.Add( "PlayerSay", "JonZChatCommands", chatCom)