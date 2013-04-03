local client_modules = {}
local serverStarted = false;

startServer()

	if SERVER then
		local client_modules = file.Find( "dblogging/dbmodules/cl/*.lua", "LUA" )
		serverStarted = true;
	end
	
	
end

startClient()

	if not serverStarted then
		timer.Simple(5, startServer)
		return
	end
		
	if CLIENT then
		for _, files in ipairs( client_modules ) do
			include( "dbmodules/cl/" .. file )
		end
	end	
end