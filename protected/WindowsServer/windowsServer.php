<?php
require "../../includes/header.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Windows Tip Sheet</title>
<script src = "windows.js" defer></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

Last updated: Nov 2022
<h1>Cyberpatriot Windows Tip Sheet</h1>

<h2 id="toc">Table of Contents</a></h2>
<a href="#software">System Updates &amp; Software</a></br>
<a href="#filesystem">File System</a></br>

<a href="#secpol">Security Policy</a></br>
<a href="#gpedit">Local Group Policy</a></br>
<a href="#gpo">Global Domain Policy</a></br>
<a href="#lusrmgr">Local User Management</a></br>
<a href="#network">Network Secuity</a></br>
<a href="#services">Services & Processes</a></br>
<a href="#browser">Browser Settings</a></br>
<a href="#logs">Log Files and Event Logs</a></br>
<a href="#misc">Misc. Security</a></br>
<a href="#locations">Common Windows file locations</a></br>
<a href="#snapins">Microsoft Management Console Snap-ins</a></br>
<a href="#advanced">Advanced Tips</a></br>

<h2>Checklist</h2>


<?php
require "../../includes/config1_m.php";
$query = "SELECT * FROM comp_log WHERE team_id='". $_SESSION['team_id'] . "' AND os='windows-10' AND round_id=(SELECT round_id FROM rounds WHERE team_id='" . $_SESSION['team_id'] . "')";
$result = $conn1->query($query);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if ($row['checked'] == "1") {
     echo "<br><input type='checkbox' class='thecheckbox' id='" . $row["id"] . "' checked/>"  . $row["item"] . "<br/>"; 
    } else {echo "<br><input type='checkbox' class='thecheckbox' id='" . $row["id"] . "'/>"  . $row["item"] . "<br/>";}
  }
}
?>

<script type="text/javascript">
  $('.thecheckbox').change(function(e){
    // Get row id or whatever you need to relate it to info in the DB
    rowid = $(e.target).attr('id');
    isChecked = $(e.target).is(':checked');
    data = {id: rowid, active: isChecked, os: 'windows-10'};
    
    $.ajax({
        url: '../../includes/update_db.php',
        method: 'POST',
        dataType: 'json',
        data: data
    });
    
});
</script>




<pre>
<div id ="checkbox-container">
<input type="checkbox" id="hidden">Enable hidden files and file extensions in file system view options <a href="#filesystem">File System</a>
<input type="checkbox" id="firewall">Enable the firewall <a href="#network">Network Security</a>
<input type="checkbox" id="antivirus">Enable/verify antivirus is running <a href="#gpo">Global Domain Policy</a>
<input type="checkbox" id="eventlog">Enable/verify that Windows Event Log service is running (services.msc) <a href="#services">Services & Processes</a>
<input type="checkbox" id="update">Enable/verify Windows Update service/Software Updates are running.  (START SYSTEM UPDATES) <a href="#software">System Updates &amp; Software</a>

<input type="checkbox" id="forensics">EVALUATE THE FORENSIC QUESTIONS
    Forensic question generally asks for a directory where an unauthorized file or user was found. Check FORENSICS before removing anything!
    DON'T get bogged down in the forensics, but be careful not to delete evidence!

<input type="checkbox" id="evidence"> SAVE EVIDENCE. If a file, immediately make a copy of the forensic file and place on the host system so we don't forget

<input type="checkbox" id="reconcile">Reconcile authorized users (lusrmgr.msc)
<input type="checkbox" id="users">create a text file containing authorized users from the README
<input type="checkbox" id="unauthorizedusers"> Remove unauthorized users <a href="#lusrmgr">Local User Management</a>
<input type="checkbox" id="missing">Add any missing authorized users <a href="#lusrmgr">Local User Management</a>
<input type="checkbox" id="admins">Remove non-admins from admin group/set them to standard user <a href="#lusrmgr">Local User Management</a>
<input type="checkbox" id="directories">Remove unauthorized user directories c:\users or /home (BUT do your forensics first!) <a href="#filesystem">File System</a>
<input type="checkbox" id="fileshare">Look for unauthorized file shares (check the README and Forensics first) <a href="#filesystem">File System</a>
<input type="checkbox" id="permissions">Check file permissions (read your readme file!!!!) <a href="#filesystem">File System</a>

<input type="checkbox" id="script">Run CP_winscript.ps1 on Windows (PowerShell run as administrator)
<a href = 'CP_winscript.ps1' download="CP_winscript.ps1">Download CP_winscript.ps1</a> <strong>RIGHT CLICK ON LINK AND PRESS SAVE LINK AS(IF NO DOWNLOAD</strong> 
<a href = 'LGPO.exe' download="LGPO.exe">Download LGPO.exe</a> <strong> RIGHT CLICK ON LINK AND PRESS SAVE LINK AS (IF NO DOWNLOAD)</strong> 
<a href = 'GptTmpl.inf' download="GptTmpl.inf">Download GptTmpl.inf</a> <strong>RIGHT CLICK ON LINK AND PRESS SAVE LINK AS(IF NO DOWNLOAD</strong> 

<input type="checkbox" id="import">Run the <strong>"lgpo.exe /s GptTmpl.inf"</strong> import 

<input type="checkbox" id="gpo">Group Policy <a href="#gpo">Global Domain Policy</a>
    
<input type="checkbox" id="default">Update the default browser as indicated in the README file (e.g. Firefox) <a href="#browser">Browser Settings</a>
    <input type="checkbox" id="popup"> Firefox pop-up blocker enabled
    <input type="checkbox" id="firefoxupdates">Firefox automatically installs updates
<input type="checkbox" id="software update">Update all required, valid software to latest version as defined in README
<input type="checkbox" id="badprogram"> Remove unsanctioned and unwanted programs. <a href="#software">System Updates &amp; Software</a>

<input type="checkbox" id="badservice">Stop and disable unauthorized services
    o run netstat -ant and check for listening services.  
	  Check your services file to see what ports map to what services
           Win: C:\Windows\System32\drivers\etc\services

<input type="checkbox" id="badfiles">Remove unauthorized files (mp3, m4b, .aa, .mkv, .m4r) (did you do forensics first?!)
<input type="checkbox" id="hacking">Remove hacking tools (nmap, rainbowcrack, ophcrack,*crack*, xhydra, wireshark, openvpn, betternetVPN, *sploit*) (did you do forensics first?!)
<input type="checkbox" id="remote"> Set remote access related settings (RDP, openSSH) defined in README
</div>
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="software">System Updates &amp; Software</h2>
<pre>
!!!!!!!!! <strong style="color:Tomato;">Start your updates early so they have time to finish</strong> !!!!!!!!!!!

Windows Update Settings.  From taskbar, search for "update".  
  Check for updates

  <strong style="background-color:Yellow;">Note:</strong> During or following updates, restart if/when prompted.  If the system prompts to restart for updates to complete, you are safe to do so.

  * If Windows update won't run... 
        Check that the Windows Update service is running and/or not disabled.
        Check that the Windows Event Log service is running and/or not disabled.
        Check that Background Intelligent Transfer Services (BITS) service running and/or not disabled. 
    
    Or try to run Windows Update Troubleshooter
        From search bar, type Troubleshooter
        Click on Troubleshooting
        Click on Windows update troubleshooter
  
Remove unauthorized software and programs
  From search bar, type "Programs"
  OR
  Control Panel\Programs\Programs and Features

Update any required software as listed in the README
	Typically, you can open the software application and find under Help->About and get the current version.  Then Google for the software and check for the lastest version.

</pre>
<a href="#toc">back to toc</a></br>
<h2 id="filesystem">File System</h2>
<pre>
Set Windows Explorer to show Hidden items and File name extentions
  From explorer, Tools--&gt; Folder Options --&gt; View tab --&gt; Show hidden files, folders, and drives
OR 
  from administrator CMD or Powershell window
    reg add HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Advanced /v Hidden /t REG_DWORD /d 1
    reg add HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Advanced /v HideFileExt /t REG_DWORD /d 0

Look for files containing sensitive information, such as credit card numbers, usernames etc. (do forensics first!)
    Look in c:\users\&lt;username&gt; Downloads, Documents, Music, Video.
    (they can even be simple .txt files)
    gci -Recurse c:\users -Include *.txt | select-string "pass", "card", "cvv", "SSN", "phone"
  gci c:\users -Include *.mp3,*.pdf,*.docx -Recurse

    * Note: Run command window as Administrator.

    Use explorer and manually look for unusual files in c:\users\&lt;username&gt; and below.
    
Look for unauthorized files (do forensics first!)
  dir /s /a:h (subdirs and files with hidden attribute)
  dir /s | findstr /i "&lt;filename string pattern&gt;"
  dir /?
  PS: Get-Childitem c:\ -recurse &lt;filename&gt; (gci is a shortcut for Get-Childitem)
        gci -Recurse c:\users -Include *.mp3,*.mp4,*.txt    

Look for other unauthorized files
  C:\program files and c:\program files(x86).
    Ophcrack, Rainbowcrack, wireshark, nmap, "home web server", DriverUpdate.

Remove unauthorized file shares (do forensics first!)
  NET SHARE /? for help
  NET share /del &lt;sharename&gt;

Disable Public Sharing
  Control Panel\Network and Internet\Network and Sharing Center\Advanced sharing settings\ : Turn off for all networks

Get a file hash value
    PS: Get-FileHash  &lt;filename&gt; -Algorithm (md5 | sha1 | sha256)

Find owner of a file
  CMD: dir /q 
   PS: Get-Acl &lt;filename&gt;
    
Check magic byte to determine true file type.  For example, a file may be executable, but renamed as a .txt as attempt to hide it.
  PS: Format-Hex -Path &lt;filename&gt; | Select-Object -First 1
  OR
  PS: cat &lt;filename&gt;  (look at the very first few bytes)
  
File magic byte in the first part of the file to identify real file types.

    "MZ" or "PE"    - Windows Executable
    ".ELF"          - ELF Executable and Linkable Format
    "PK.."          - Zip Archive
    "7z"            - 7Zip Archive
    "Rar!...."      - Rar Archive
    ".PNG...."      - PNG Image
    "BM"            - BMP Image
    "GIF"           - GIF Image
    "%PDF"          - Portable Document Format

Mark-of-web
   Can be seen on file properties via file explorer will show an unblock option if it was downloaded from web.
   local computer = 0
   local network = 1
   trusted =2
   internet = 3
   restricted = 4

Folder &amp; File Permissions
   If you find a folder with unauthorized files but can't get to it.
   Right click folder and choose Properties -&gt; Security
   Click Edit and add the Administrators group to the permissions.
   You may need to click Advanced and next to Owner at the top, click "Change" to Take Ownership

Check permissions on a folder or file from command-line
    icacls &lt;path to folder&gt; Example:icacls c:\temp
    icacls &lt;path to file&gt; Example: icacls c:\temp\myfile.exe

File attributes
    dir /? (get help on the different attributes.  Is there hidden files?)
    From explorer, right click the file and look at the properties.  
    
Look at the PowerShell history file for users
    C:\Users\&lt;username&gt;\AppData\Roaming\Microsoft\Windows\PowerShell\PSReadLine\ConsoleHost_history.txt
	
Alternate Data Streams (ADS)
   echo "nothing to see here" &gt; basicfile.txt
   echo "supersecret stuff" &gt; basicfile.txt:stuff
   dir /r *.txt
   more &lt; basicfile.txt
   more &lt; basicfile.txt:stuff

   /r - displays alternate data streams of a file

   dir /r &lt;filename&gt;
   more &lt; &lt;filename&gt; 
   
   Sysinternals (Google search) has a utility called "streams.exe" that you can download and use to remove alternate data streams.
   
   C:\SysinternalsSuite>streams -d c:\Users\rdeshazer\basicfile.txt

    streams v1.60 - Reveal NTFS alternate streams.
    Copyright (C) 2005-2016 Mark Russinovich
    Sysinternals - www.sysinternals.com
    
    c:\Users\rdeshazer\basicfile.txt:
       Deleted :secret:$DATA
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="secpol">Security Policy Settings (secpol.msc)</h2>
<pre>
Run the <strong style="color:Tomato;">"lgpo.exe /s GptTmpl.inf"</strong> import.  That will set all of these for you.

o Account Policies
    Password Policy
      o Enforce password history/remembered: 5
      o Max age: 90 for standard users, 30 for admins
      o Min age: 10-30 days
      o Min Length: 10
      o Password complexity: enabled
      o Reversible encryption: Disable   
    Account lockout policies
      o Duration: 30 min
      o Lockout threshold: 6-10
      o Reset after: 30 min

User Access Control Settings
    From start, type "user access control"
    In the resulting dialog, slide the slider to the top "Always Notify".

View account policy summary from adminstrator command prompt
  CMD: NET accounts
  (can actually set some values but we already did that in policy e.g. NET ACCOUNTS /uniquepw:5 /minpwlen:10 /maxpwage:90)

Local Policies 
    Audit Policy
        Set all audit policies to log Success and Failure (check both boxes)
        OR
        Do it all at once from an administrator CMD or Powershell window
    
        auditpol /set /category:* /failure:enable /success:enable
        auditpol /set /subcategory:"Account Lockout" /success:enable /failure:enable   
        auditpol /set /subcategory:"User Account Management" /success:enable /failure:enable   
      
        [reference only - do not run]: auditpol /set /category:"System","Account Management","Object Access","Detailed Tracking","DS Access","Privilege Use","Account Logon","Logon/Logoff","Policy Change" /failure:enable /success:enable

    User Rights Assignment
        o Access this computer from the network (remove "Everyone") ** UNLESS the readme says otherwise **

    Security Options https://learn.microsoft.com/en-us/windows/security/threat-protection/security-policy-settings/security-options
        * Accounts: Limit local account use of blank passwords to console logon only (Enabled)
        * Interactive Logon: Do not display last signed-in. (Enabled)
        * Interactive login: Do not require CTRL-ALT-DEL (Disabled)
        * User Account Control: Behavior of the elevation prompt for administrators in Admin Approval Mode (Prompt for Consent)
        
        o Accounts: Administrator account status (Disabled)
        o Accounts: Guest account status (Disabled)
        o Microsoft network client: Digitally sign communications (if server agrees) (Enabled)
        o Microsoft network server: Digitally sign communications (if client agrees) (Enabled)
        o Network access: Allow anonymous SID/Name translation (Disabled) 
        o Network access: Do not allow anonymous enumeration of SAM accounts and shares (Enabled)
        o Network access: Do not allow anonymous enumeration of SAM accounts(Enabled)
        o Network access: Do not allow storage of passwords and credentials for network authentication (Enabled) 
        o Network access: Restrict anonymous access to Named Pipes and Shares (Enabled)
        o Network security: Do not store LAN Manager hash value on next password change (Enabled)
        o User Account Control: Detect application installations and prompt for elevation (Enabled)
        o User Account Control: Admin Approval Mode for the Built-in Administrator account (Enabled)

    Use free Microsoft tool Local Group Policy Object(LGPO) utility.  This allows an import of a preconfigured configuration file
    and sets both secpol settings and audit settings!
    
    https://techcommunity.microsoft.com/t5/microsoft-security-baselines/lgpo-exe-local-group-policy-object-utility-v1-0/ba-p/701045
    
    Pre-req work to be done BEFORE compitition: LGPO.exe /b c:\temp
    
    1. copy LGPO.exe and GptTmpl.inf to VMguest c:\temp
    2. From elevated command prompt, run: LGPO.exe /s GptTmpl.inf
    
    Reference only: registry settings here: Computer\HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\SecEdit\Reg Values

Advanced Audit Policy Configuration
    System Audit Policies
    double-click Account Logon
    double-click Audit Credential Validation -&gt; check the Configure the following audit events box -&gt; select Failure -&gt; select Apply → select OK
 
[[ Advanced tips - try only if standard process above is not working ]]

https://learn.microsoft.com/en-us/troubleshoot/windows-server/windows-security/security-auditing-settings-not-applied-when-deploy-domain-based-policy

    - Locate and then click the registry subkey: HKEY_LOCAL_MACHINE\System\CurrentControlSet\Control\LSA.
    - Right-click SCENoApplyLegacyAuditPolicy, and then click Modify.
    - Type 0 in the Value data box, and then click OK.
    - Exit Registry Editor.
    - Restart the computer.

If the audit policy does not stay enabled as you set you, try the following.
Use AUDITPOL.EXE to clear audit policy
    AUDITPOL.EXE /clear
     
    Remove the following files to clear any enforcement
    c:\Windows\security\audit\audit.csv
    c:\Windows\System32\GroupPolicy\Machine\Microsoft\WindowsNT\Audit\audit.csv
    c:\Windows\System32\GroupPolicy\gpt.ini 
    
    ...then rebooting put Local Security Policy back into a state where it didn't think it needed to apply advanced audit policy.  Any changes using AUDITPOL.EXE or AuditSetSystemPolicy(...) then survived local policy application.  "GPRESULT /H ResultsAfter.htm" also confirmed that audit policy was not being  applied.
    
    https://social.technet.microsoft.com/Forums/windowsserver/en-US/03cb345e-baf1-45b7-97e1-b3b7a9ebe119/audit-policy-reset-on-restart
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="gpedit">Local Policy Settings (gpedit.msc)</h2>
<pre>
Computer Configuration (Refer to README first if it says remote management is needed)
    Administrative Templates
        Network
            Lanman Workstation
                Enable insecure guest logons (Disabled)
        Windows Components
            Remote Desktop Services
                Remote Desktop Session Host
                    Connections
                        Allow users to connect remotely by using remote desktop services, select Enable
                    Device and Resource Redirection
                         Do not allow supported Plug and Play device redirection. In the setting window that appears, select Enable
            AutoPlay Policies
                Turn off Autoplay (Enabled)
                Disallow Autoplay for non-volume devices (Enabled)
            Windows Remote Management (WinRM)
                WinRM Service
                    "Allow Basic authentication" (Disabled)
                    "Allow remote server management through WinRM" (Disabled)
            Windows Update
                Configure Automatic Updates
                    Enabled
                    4 - Auto download and schedule the install
                    Install during automatic maintenance
                    0 - Every day
                    Install updates for other Microsoft products (at the very bottom) 
    All Settings
            Turn off Microsoft Defender Antivirus (Disabled)
            Turn off Autoplay (Enabled)
            
Also check Windows Defender reg key at HKLM\Software\policies\Microsoft\Windows Defender

</pre>
<a href="#toc">back to toc</a></br>
<h2 id="gpo">Global Domain Policy</h2>
<pre>
Policy can be set at a DOMAIN level that domain members inherit policy from.  If you are changing local policy 
or get messages saying restricted "by your administrator",this may indicate an overriding DOMAIN policy.

    CMD: gpresult /h %temp%\policy.htm
        View the report and look for Default Domain policy entries
    
    MMC snap-in Group Policy Management Console (gpmc.msc)
    Default Domain policy
    Look for "Prevent windows applications" entry.

Run rsop.msc (Resultant Set of Policy) and look for any policies set with a "Source GPO" other than local

Order that policy applies:  Local, Site, Domain, Organizational Units (OU).  Higher level policies win (right most in this list).
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="lusrmgr">Local User Management (lusrmgr.msc) (netplwiz.exe)</h2>
<pre>
Remove unauthorized users (compare user list to those listed in the README)
  CMD: NET USER
  GUI: lusrmgr.msc
   PS: Get-Localuser | sort | ft name  [to save to a file = Get-Localuser | sort | ft name &gt; users.txt]

Ensure all users have strong passwords set
  To set all user passwords, run the <strong>CP_winscript.ps1</strong> script.

Control Panel -&gt; User Accounts -&gt; Manage Another Account
  Look for users that don't show as "Password protected" (excluding yourself as the admin e.g. ballen)

Rename and disable the default Administrator and Guest accounts
  GUI: lusrmgr.msc
  Right click, rename to something like "cybergal" or whatever
  Right click, properties, check "Account is disabled"

Check Administrators group membership.  Ensure only those listed in README are in the administrators group.
  CMD: net localgroup administrators  
  GUI: lusrmgr.msc
   PS: Get-LocalGroupmember administrators

Check for user account details such as lockouts, password last changed etc.
  NET USER &lt;username&gt;

Check who is logged in
    CMD: query user

Check misc user account attributes  
  CMD: netplwiz.exe
    Require ctrl+alt+del
    Add users to remote desktop users (check readme)
 
Set User Account Control to prompt Admin Approval Mode

    Open the “control panel” desktop app. In the menu select “System and Security”.
    Under “Security and Maintenance”, select “Change User Account Control
    Settings”. 

    Use the slider in “Change User Account Control Settings” from “Never Notify” to
    “Always Notify”. Select “OK”, then “Yes”. 

Check for hidden user accounts
  CMD: reg query "HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" # look for a key called SpecialAccounts and a userlist
  GUI: regedit and navigate to the registry key above

</pre>
<a href="#toc">back to toc</a></br>
<h2 id="network">Network Security</h2> 
<pre>
Turn on Firewall 
  From a command prompt running as administrator:
  netsh advfirewall set allprofiles state on 
 or
  start -&gt; run -&gt; firewall and check all three profiles...domain, public, private

Allow required services on Firewall (e.g. port SSH 22 or RDP 3389) Whatever "critical services" the README says
  Examples: 
  netsh advfirewall firewall add rule name= "Allow RDP" dir=in action=allow protocol=TCP localport=3389
  netsh advfirewall firewall add rule name= "Allow Web" dir=in action=allow protocol=TCP localport=80
  netsh advfirewall firewall add rule name="allow laptop cifs" dir=in action=allow protocol=TCP localport=445 RemoteIP=192.168.130.53
  
Remote Desktop (RDP) check README which may mention teleworker or remote access is required or not.  Determine if it should be on or not! 
  Control Panel\System and Security\System -&gt; remote settings (sysdm.cpl)
   Check (or uncheck) Allow Remote Assistance connections to this computer
     Check (or uncheck) the "allow connections...Network Level Authentication" checkbox 

Check for listening ports
  netstat -ant
  netstat -anto to look for owning processes. Then open task manager to look for details on that task. 
  
  Service ports of interest. Should these be listening according to readme? 
    80(http), 443(https), 21(ftp), 22(ssh), 3389(rdp), 5985(WinRM), 5986(WinRM secure) 
  
  see c:\windows\system32\drivers\etc\services for reference.  Also look at your c:\windows\system32\drivers\etc\services file.

Review Security Center details.  Make sure firewall and virus protection are enabled
  start -&gt; Control Panel -&gt; System and Security -&gt; Security and Maintenance -&gt; Security 

Verify the hosts file has only default entries in it and nothing unusual
    c:\windows\system32\drivers\etc\hosts
        #
        # For example:
        #
        #      102.54.94.97     rhino.acme.com          # source server
        #       38.25.63.10     x.acme.com              # x client host

        # localhost name resolution is handled within DNS itself.
        #       127.0.0.1       localhost
        #       ::1             localhost
        10.10.10.2 inside.pier14.net &lt; ------------ Example of something that's been added

Check your network interfaces.  Anything unusual? Extra interfaces? (typical "wireless*", "VMnet", "Ethernet*")
    ipconfig /all

Download and run the Microsoft Safety Scanner
    https://docs.microsoft.com/en-us/microsoft-365/security/intelligence/safety-scanner-download?view=o365-worldwide

</pre>
<a href="#toc">back to toc</a></br>
<h2 id="services">Services &amp; Processes</h2>  
<pre>
Run services.msc 
OR 
Task Manager and click on Services tab

(Optional) quick look for running services with PowerShell...
    Get-Service | where {$_.status -like "running"} | Sort-Object displayname
 
Ensure required/authorized services and programs listed in the README are updated and running
Check that these specifically are running...
  Windows Update
  Windows Defender *
 
Ensure Windows Defender antivirus is running
  From taskbar, search for "virus"
  Make sure Realtime Protection is on

Disable unauthorized services
   Here is a list of services to look for and set startup type to disabled, and stop the service :
   (ftp, web, telnet, samba, smbv1, Remote Registry, SSDP, SMTP, "net.tcp port sharing service",WinRM (Windows Remote Management), "Simple TCP/IP")
 
Look for startup programs
    Task Manager -&gt; StartUp
    
    AND/OR
    
    Run and RunOnce registry keys cause programs to run each time a user logs on.

    The Windows registry includes the following four Run and RunOnce keys:

    reg query HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Run
    reg query HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\RunOnce
    reg query HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run
    reg query HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\RunOnce

Reference: Lookup running process details from http://www.processlibrary.com/en/ 

Review svchost processes for unusual process names
   tasklist /fi "imagename eq svchost.exe" /svc
    
    Note: Make sure there is not a process called svchosts.exe (with an "s" on the end)

Create a whitelist of trusted processes (precompetition task)
    Lookup Hunting Evil from Sans.org

</pre>
<a href="#toc">back to toc</a></br>
<h2 id="browser">Browser Settings </h2>
<pre>
Firefox browser General settings
  Set as default browser
  Set to automatically installs updates
  Update to latest version ( may need to run a few times)
  
Privacy &amp; Security
  Block pop-ups
  Warn you when websites try to install add-ons
  Block dangerous and deceptive content

Check for unusual add-ons (about:addons)
  Extentions and Plugins
  Settings -&gt; Extensions &amp; Themes

</pre>
<a href="#toc">back to toc</a></br>
<h2 id="logs">Log Files and Event Logs</h2>
<pre>
Ensure Event Log service is running
    net start eventlog
    services.msc and ensure "Windows Event Log"  is set to automatic
    
Ensure Windows Event logs are enabled
    wevtutil gl "system"
    wevtutil gl "security"
    wevtutil gl "application"
    wevtutil gl "windows powershell"
    wevtutil gl "Microsoft-Windows-PowerShell/Operational"

Where to investigate for clues or other hints of malicous files or behaviors

Windows Event logs (eventvwr.msc)
    Most common
        Windows Logs
            security
            application
            system
    Others of interest
        Applications and Services Logs
        
IIS Web Server
    C:\inetpub\logs\LogFiles\W3SVC
    
FTP Logs
    C:\inetpub\logs\FTPSVC2

Firewall Logs
    c:\windows\system32\logfiles\firewall\pfirewall.log

</pre>
<a href="#toc">back to toc</a></br>
<h2 id="misc">Misc. Security</h2>
<pre>
Check for scheduled tasks (taskschd.msc)
    start button -&gt; search -&gt; scheduled tasks
    In the Actions pane on the right, make sure the View -&gt; Show Hidden Tasks is enabled
    
    Via the registry...
    
    HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Schedule\TaskCache\Tree\TASK_NAME
    HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Schedule\TaskCache\Tasks\{GUID}
    
    Scheduled Tasks create persistent files on the file system
    • %systemroot%\System32\Tasks - The “newer” tasks API
    • %systemroot%\Tasks - AT jobs (now deprecated)

Look for persistence in the startup folders
    C:\ProgramData\Microsoft\Windows\Start Menu\Programs\StartUp
    %appdata%\Microsoft\Windows\Start Menu\Programs\Startup 
    C:\Users\&lt;username&gt;\AppData\Roaming 

Look for persistence in the registry (MITRE ATT&amp;CK ID T1547.001)

    HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run  
    HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\RunOnce  
    HKEY_CURRENT_USER\Software\Microsoft\Windows NT\CurrentVersion\Windows\load  
     
    HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Run  
    HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\RunOnce  

    Entries for services
    HKEY_LOCAL_MACHINE\SYSTEM\CONTROLSET001\SERVICES
    
    Similarly, the registry keys that are used to launch programs or set folder items for persistence are:  

    HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\User Shell Folders  
    HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Shell Folders  

    HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\Shell Folders  
    HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\User Shell Folders  
  
Taskmgr 
  look for running services and processes.  Look for unusual or unauthorized processes. 

Enable Protected Folder Access
    Virus &amp; threat protection -&gt; Ransomware protection -&gt; Manage ransomware protection. Turn slider switch On
    
Sysinternals tools are a variety of tools that can be helpful.
    Accessable via \\live.sysinternals.com\tools from a browser
    OR
    \\live.sysinternals.com\tools\&lt;toolname&gt; from a CLI prompt (must have "webclient" service running). 
        e.g. \\live.sysinternals.com\tools\tcpview
             \\live.sysinternals.com\tools\strings &lt;filename&gt;

        Process Explorer(procexp), tcpview, Strings and Autoruns are recommended

    TODO: investigate use of Bstrings. https://github.com/EricZimmerman/bstrings

Enable/Check Data Execution Prevention (DEP)
    Control Panel -&gt; System -&gt; Advanced system settings -&gt; Advanced Tab -&gt; Performance Settings
        O Turn on DEP for essential Windows programs and services only

Check system path for unusual entries
    CMD: echo %PATH%
     PS: echo $env:path

</pre>
<a href="#toc">back to toc</a></br>
<h2 id="locations">Common Windows file locations</h2>
<pre>
Not an exhaustive list, but here's where Windows keeps files:

\Windows - OS related files in this tree
\Windows\Prefetch - Prefetch files (good for forensic examination of processes that have run - may not be enabled on server by default)
\Windows\System32 - Windows internal services/applications/etc.
\Windows\System32\Drivers\etc - hosts, lmhosts, services, etc.
\Windows\System32\winevt\logs - Physical files for Windows event logs
\Windows\Temp - Temporary files (generally nothing should be executing from this folder)

\Program Files - Microsoft and 3rd party applications 
\Program Files (x86) - Microsoft and 3rd party applications

\ProgramData - Temp or support space for installed applications (Usually config files/cache/etc.)

\Users - User homes and related filess
\Users\Default - Default/template user profile
\Users\Public - Common/shared user profile folders
\Users\&lt;username&gt; - One username folder for each user on the system, stores user specific files

\Users\&lt;username&gt;\AppData - User specific application data.  Programs should generally not execute from this folder path (but sometimes do if poorly coded)
\Users\&lt;username&gt;\AppData\&lt;Local|LocalLow|Roaming&gt; - Difference mostly only matters in a corporate setting, sub folders are similar user
\Users\&lt;username&gt;\AppData\&lt;...&gt;\Temp - User specific temporary storage.  Common for malware to try to hide here
\Users\&lt;username&gt;\&lt;Desktop|Favorites|Pictures|Documents|Downloads|...&gt; - Storage location for user specific information ("My Documents" etc.)
\Users\&lt;username&gt;\NTUSER.DAT - File storage for part of the user specific portion of the registry 
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="snapins">Microsoft Management Console Snap-ins</h2>
<pre>
Use these most common snap-ins.  Each can be launched from Start-&gt;Run or a command window, or search bar.
  
  compmgmt.msc  Computer managment.  can get to users, drives, services  
  control :     Control Panel  
  lusrmgr.msc : Local Users and Groups 
  sysdm.cpl:    System properties
  Secpol.msc :  Local Security Policy
  gpedit.msc:   Local Group Policy Editor
  Services.msc :local Services running on the system.
  Firewall :    local Firewall settings (netsh advfirewall set allprofiles state on) 
  taskmgr:      get to services tab and see what processes are running
  Dcomcnfg.exe  Distributed COM configuration
  systeminfo (run from CLI):   Gives a summary of system information
  taskschd.msc  show task scheduler
  
  Setup "godmode" (optional)
  Create a new folder on the desktop and rename it as follows:
  GodMode.{ED7BA470-8E54-465E-825C-99712043E01C}
  (other like items to try)
  Default Programs.{17cd9488-1228-4b2f-88ce-4298e93e0966}
  My Computer.{20D04FE0-3AEA-1069-A2D8-08002B30309D}
  Network.{208D2C60-3AEA-1069-A2D7-08002B30309D}
  Programs and Features.{15eae92e-f17a-4431-9f28-805e482dafd4}
  Power Settings.{025A5937-A6BE-4686-A844-36FE4BEC8B6D}
  Icons And Notifications.{05d7b0f4-2121-4eff-bf6b-ed3f69b894d9}
  Firewall and Security.{4026492F-2F69-46B8-B9BF-5654FC07E423}
 </pre>
<a href="#toc">back to toc</a></br>
<h2 id="advanced">Advanced Tips - Not proven to give us points, but worth looking at and training ideas</h2>
<pre>
TODO: review https://docs.microsoft.com/en-us/windows/security/threat-protection/security-policy-settings/security-options

Check for RunOnceEx entries that executes each time a user logs in
  HKLM\SOFTWARE\Microsoft\Windows\CurrentVersion\RunOnceEx
  See this link for more information (but don't waste a lot of time): https://github.com/redcanaryco/atomic-red-team/blob/master/atomics/T1547.001/T1547.001.md

Disable NBT-NS
  Adapt Netbios settings in network connection properties -&gt; Advanced -&gt; WINS -&gt; Disable NetBIOS over TCP

Disable LLMNR
(may have lost us points.  DO NOT USE.  Let's test in practice rounds) Disable LLMNR from the group policy (gpedit.msc)
  Local Computer Policy -&gt; Computer Configuration -&gt; Administrative Templates -&gt; Network -&gt; DNS Client -&gt; 
    Turn off multicast name resolution - Enable

    REG ADD  “HKLM\Software\policies\Microsoft\Windows NT\DNSClient”
    REG ADD  “HKLM\Software\policies\Microsoft\Windows NT\DNSClient” /v ” EnableMulticast” /t REG_DWORD /d “0” /f

Disable LLMNR on Linux (Ubuntu):
   Edit the line LLMNR=yes to LLMNR=no in /etc/systemd/resolved.conf

Install AV (caution! - potentially disables or prevents Window Defender)
 search web for and install AVAST
 www.ninite.com and select AVAST and/or malwarebytes

Enable AppLocker - gpedit.msc
    Open "Computer Configuration"
    Open "Windows Settings"
    Open "Security Settings"
    Open "Application Control Policies"
    Open "AppLocker"
    TODO: define rules

Autoruns to look for persistence
  autorunsc.exe -nobanner -accepteula -a * -m -c

Disable Distributed COM (DCOM)
   reg add hklm\software\microsoft\ole /v EnableDCOM /t REG_SZ /d N /f
   https://technet.microsoft.com/en-us/library/dd632946.aspx
   * must restart for change to take effect.

Windows Server Manager - You might be asked questions about properties of these.
  Tools - DNS
  Tools - Web

Install Microsoft Baseline Security Analyzer (MBSA) 
  c:\cyberpatriot\MBSASetup-x64-EN.msi 
  OR search and download 2.3 or greater  us/download/details.aspx?id=7558 

Install Microsoft Safety Scanner
  https://www.microsoft.com/en-us/wdsi/products/scanner
 
 RestrictAnonynmous - set to 0  
  https://technet.microsoft.com/en-us/library/bb418944.aspx
</pre>
<a href="#toc">back to toc</a></br>
</body>
</html>
