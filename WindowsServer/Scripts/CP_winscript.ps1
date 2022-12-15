# *** Functions *********************************************************************************************

function Show-Menu {
    param (
        [string]$Title = 'Menu'
    )
    Clear-Host
    Write-Host "Boise Bee Cyberpatriot Windows script `n"  
	Write-Host -ForegroundColor Yellow "MUST RUN SHELL AS ADMINISTRATOR! `n"
    Write-Host "=============== $Title ================`n"
    
    Write-Host "1: Get List of Local Users"
    Write-Host "2: Set Local User Passwords"
	Write-Host "3: Get Status of Key Services"
    Write-Host "4: Show All Running Services"
    Write-Host "Q: Press 'Q' to quit.`n"
    Write-Host "====================================="
}

function GetLocalUsers{
    Write-Host "`nHere is a list of local users on this system.  Compare these closely to the administrators and authorized users listed in the README. `n"
	(Get-LocalUser).Name | Where-Object {($_ -ne "Guest") -and ($_ -ne "Administrator") -and ($_ -ne "WDAGUtilityAccount") -and ($_ -ne "DefaultAccount")} | sort
    Write-Host `n
}

function SetPasswordPolicy{
    #TODO: figure out registry values to set
    Write-Host "Nothing here yet!"
}

function SetUserPasswords{
# Prereq: Create a file with the list of valid users (e.g. users.txt) DO NOT INCLUDE THE ADMIN ACCOUNT YOU ARE LOGGED INTO!
	
    #$password = Read-Host -Prompt "Enter standard password: " -AsSecureString  
    $newPass = "BoiseBee#1"
	$path = Read-Host -Prompt "Enter the full path to users file created from the readme file (e.g. c:\temp\users.txt)"
    
    if (($path -ne "") -and (Test-Path -path $path)){
        foreach ($user in (Get-Content $path)) {
            try{
                Write-Host "`n *** Changing password for user: $user" -ForegroundColor Yellow
                Get-LocalUser $user | Set-LocalUser -PasswordNeverExpires:$false -Password (ConvertTo-SecureString -AsPlainText "$newPass" -Force)
            }
            catch{
                Write-Host $error
                #Write-Host "Error changing password for $user.  Is it a valid user?"
            }
            
        }       
    }
    else {
        Write-Host "Doh! That file path does not exist!"ErrorDetails
    }    
    Write-Host "`nUser passwords set!`n" -ForegroundColor Cyan
}

function CheckKeyServices{
	#Get-ItemProperty HKLM:\Software\Wow6432Node\Microsoft\Windows\CurrentVersion\Uninstall\* | sort | ft displayname
    Get-Service | where {$_.name -like "wuauserv" -or $_.name -like "windefend" -or $_.name -like "WdNisSvc" -or $_.name -like "EventLog" -or $_.name -like "mpssvc"} | Sort-Object displayname
	Write-Host -ForegroundColor Red "These key services should have a status of Running!`n"
}

function GetInstalledPrograms{
	#Get-ItemProperty HKLM:\Software\Wow6432Node\Microsoft\Windows\CurrentVersion\Uninstall\* | sort | ft displayname
    Write-Host "Not quite ready yet! Sorry."
}

function SetSecPol{
    #TODO: figure out registry values to set
    Write-Host " :-( Nothing here yet!"
}

function SetAuditPol{
    #Write-Host "Nothing here yet!"
    auditpol /set /category:* /failure:enable /success:enable
    auditpol /set /subcategory:"Account Lockout" /success:enable /failure:enable   
    auditpol /set /subcategory:"User Account Management" /success:enable /failure:enable

    Write-Host "Local audit policies set.`n"
}

function GetRunningServices{
    get-service | where {$_.status -eq "Running"} | sort Displayname | ft displayname, name, status
	# alternate option with path
	#Get-WmiObject win32_service | Select-Object Name, State, PathName | Where-Object {$_.State -like 'Running'}
}

# *** Main **************************************************************************************************

#https://adamtheautomator.com/powershell-menu/

Clear-Host

do
 {
    Show-Menu
    $selection = Read-Host "Please make a selection"
        switch ($selection)
        {
        '1' {GetLocalUsers}
        '2' {SetUserPasswords}
		'3' {CheckKeyServices}
        '4' {GetRunningServices}		
        #'2' {SetPasswordPolicy}
        #'3' {GetInstalledPrograms}
        #'5' {SetSecPol}
        #'4' {SetAuditPol}

        }
    pause
 }
 until ($selection -eq 'q')

Clear-Host 
Write-Host "You quit the script.  Manually check the settings to be sure it worked!  `n"
