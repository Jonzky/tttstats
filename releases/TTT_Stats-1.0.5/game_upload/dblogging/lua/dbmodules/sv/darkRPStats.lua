local peopleToUpdate = {}

function loadPlyStats( ply )


	if not ServerStatsDB.connected then 
		
		timer.Simple( 10, loadServerStats, ply )
		ply.plytTime = 0;
		ply.dbReady = true;
		
		return; 
	end
	if not ply:IsValid() then return; end

	local escpName = db:escape( ply:Nick() )
    local tquery1 = db:query( "SELECT * FROM darkrp_stats WHERE steamid = '" .. ply:SteamID() .. "'")
    tquery1.onSuccess = function(q)
        if not checkQuery(q) then

			local tquery2 = db:query("INSERT INTO darkrp_stats(steamid, nickname, playtime, isadmin) VALUES ('" .. ply:SteamID() .. "', '" .. escpName .. "', '0', '0')")
			tquery2.onSuccess = function(q)  
			
				notifymessage("[Awesome Stats]Created: " .. ply:Nick()) 
				
				ply.plytTime = 0;
				ply.dbReady = true;
			end
			
			tquery2.onError = function(q,e) 
				notifymessage("[Awesome Stats]Something went wrong")
				notifyerror(e)
			end
			tquery2:start()
			
        else
			
			notifymessage("[Awesome Stats]Loading: " .. ply:Nick())
			local tquery3 = db:query( "SELECT * FROM darkrp_stats WHERE steamid = '" .. ply:SteamID() .. "'")
			
			tquery3.onSuccess = function(q, sdata)
			local row = sdata[1];			
				if (#tquery3:getData() == 1) then
   
					ply.plytTime = row['playtime'];
					ply.timeCheck = CurTime();
					ply.dbReady = true;

  
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

 

function savePlyStats(ply)
	
	if table.HasValue( peopleToUpdate, ply ) then return; end
	table.insert( peopleToUpdate, ply);

end


function updateplayersStuffz()

	for k, v in pairs(player.GetAll()) do
		savePlyStats(v)
	end

end
timer.Create("Updateres", 600, 0, updateplayersStuffz);

function savePlyStatsSQL()

	if #peopleToUpdate == 0 then return; end

	if not ServerStatsDB.connected then return; end
	
	ply = peopleToUpdate[1];
	table.remove(peopleToUpdate, 1)
	if ply:IsValid() then

		if ply:IsAdmin() then
			ply.isAdminz = 1
		else
			ply.isAdminz = 0
		end	
		
		updateString = "UPDATE darkrp_stats SET nickname='%s', playtime='%d', last_seen='%s', isadmin='%d' WHERE steamid ='%s'"		
		local EcName = db:escape( ply:Nick() );		
		local formQ = string.format(updateString,
						EcName,
						tonumber(getPlayTime(ply)),
						tostring(os.date()),
						tonumber(ply.isAdminz),
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
timer.Create("StatsUpdater", 5, 0, savePlyStatsSQL);

function getPlayTime(ply)
	ply.plytTime = (ply.plytTime + (CurTime() - math.Round(ply.timeCheck or CurTime())));	
	ply.timeCheck = CurTime();
	return ply.plytTime
end

function PrintStats(ply, cmd, arg )
	if ply.dbReady then
	
		ply:PrintMessage( HUD_PRINTCONSOLE, "Time played: " .. (math.Round(getPlayTime(ply)/60)) );

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


hook.Add( "PlayerInitialSpawn", "playerComes", pCome )
hook.Add( "PlayerDisconnected", "playerGoes", pGone )
