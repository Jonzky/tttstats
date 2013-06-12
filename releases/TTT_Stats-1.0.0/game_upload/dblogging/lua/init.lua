
local server_modules = file.Find( "dbmodules/sv/*.lua", "LUA" )
local shared_modules = file.Find( "dbmodules/sh/*.lua", "LUA" )
local client_modules = file.Find( "dbmodules/client/*.lua", "LUA" )

Msg( "**Loading the datase module**" )	

include("dbmodules/database/database.lua")

local function load_modules()
	
	Msg( "*******************************\n" )
	Msg( "** *  *  Database Shiz  *  * **\n" )
	Msg( "*******************************\n" )
	Msg( "**	 *Loading modules*     **\n" )


	for _, files in ipairs( server_modules ) do
		Msg( "**  Including server file: " .. files .. "**\n" )
		include( "dbmodules/sv/" .. files )
	end

	for _, files in ipairs( shared_modules ) do
		Msg( "**  Including shared file: " .. files .. "**\n" )
		include( "dbmodules/sh/" .. file )
		AddCSLuaFile( "dbmodules/sh/" .. files )
	end

	for _, files in ipairs( client_modules ) do
		Msg( "**  Including client file: " .. files .. "**\n" )
		AddCSLuaFile( "dbmodules/client/" .. files )
	end

	Msg( "*******************************\n" )
	Msg( "**    *Loading complete!*    **\n" )
	Msg( "*******************************\n" )
	
	
end	

load_modules()
