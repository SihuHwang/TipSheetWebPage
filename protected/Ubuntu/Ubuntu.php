<?php
require "../../includes/header.php";
?>

<!DOCTYPE html> 
<html>
<head>
<title>Linux Tip Sheet</title>
<script src = "ubuntu.js" defer></script>

</head>
<body>

Last updated: Nov 2022
<h1>Cyberpatriot Linux Tip Sheet</h1>

<h2 id="toc">Table of Contents</a></h2>

<a href="#software">System Updates &amp; Software</a></br>
<a href="#filesystem">File System</a></br>
<a href="#secpol">Security Policy</a></br>
<a href="#lusrmgr">Local User Management</a></br>
<a href="#network">Network Security</a></br>
<a href="#services">Services & Processes</a></br>
<a href="#browser">Browser Settings</a></br>
<a href="#logs">Log Files and PCAP files</a></br>
<a href="#misc">Misc. Security</a></br>
<a href="#locations">Common File Locations</a></br>

<h2>Checklist</h2>


<?php
require "../../includes/config1_m.php";
$query = "SELECT * FROM comp_log WHERE team_id='". $_SESSION['team_id'] . "' AND os='ubuntu' AND round_id=(SELECT round_id FROM rounds WHERE team_id='" . $_SESSION['team_id'] . "')";
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
    data = {id: rowid, active: isChecked, os: 'ubuntu'};
    
    $.ajax({
        url: '../../includes/update_db.php',
        method: 'POST',
        dataType: 'json',
        data: data
    });
    
});
</script>



<pre>
  <div id = "checkbox-container3">
<input type="checkbox" id="hidden3">Enable hidden files and file extensions in file system view options <a href="#filesystem">File System</a>
<input type="checkbox" id="firewall3"> Enable the UCF firewall <a href="#network">Network Security</a>
<input type="checkbox" id="update3">System Software &amp; Updates (START SYSTEM UPDATES) <a href="#software">System Updates &amp; Software</a>

<input type="checkbox" id="forensics3">EVALUATE THE FORENSIC QUESTIONS
    Forensic question generally asks for a directory where an unauthorized file or user was found. Check FORENSICS before removing anything!
    DON'T get bogged down in the forensics, but be careful not to delete evidence!


<input type="checkbox" id="evidence3"> SAVE EVIDENCE. If a file, immediately make a copy of the forensic file and place on the host system so we don't forget
<!--<h2><b><a href = "../UploadFiles/uploadfile.php">CLICK HERE TO UPLOAD FILES</a></b></h2>-->
    Note: if you are dealing with <strong>encryption/encoding/stegonography/hash</strong>, look in the related section in the <u>General Tips</u> sheet.

Reconcile authorized users (cat /etc/passwd)
<input type="checkbox" id="users3">create a text file containing authorized users from the README
<input type="checkbox" id="badusers"> Remove unauthorized users <a href="#lusrmgr">Local User Management</a>
<input type="checkbox" id="missing3">Add any missing authorized users and home dir <a href="#lusrmgr">Local User Management</a> (BUT do your forensics first!)
<input type="checkbox" id="admin3"> Remove non-admins from admin group/set them to standard user <a href="#lusrmgr">Local User Management</a>
<input type="checkbox" id="share">Look for unauthorized file shares (see file system section) <a href="#filesystem">File System</a> (check the README and Forensics first)
<input type="checkbox" id="filepermissions">Check file permissions <a href="#filesystem">File System</a> (read your readme file!!!!) 

<input type="checkbox" id="script3"> Run bash script on Ubuntu
    * Set secure passwords on user accounts.  Use our "BoiseBee#1" and be consistent.
    <a href = 'linux_script.sh' download="linux_script.sh">Download</a> <strong>RIGHT CLICK ON LINK AND PRESS SAVE LINK AS(IF NO DOWNLOAD)</strong> 

<input type="checkbox" id="secpol">Policy <a href="#secpol">Security Policy</a>
    
<input type="checkbox" id="firefoxupdates3"> Update the default browser as indicated in the README file (e.g. Firefox) <a href="#browser">Browser Settings</a>
    <input type="checkbox" id="popup3"> Firefox pop-up blocker enabled
    <input type="checkbox" id="autoupdate3"> Firefox automatically installs updates
<input type="checkbox" id="software3">Update all required, valid software to latest version as defined in README <a href="#software">System Updates &amp; Software</a>
<input type="checkbox" id="badprogram3">Remove unsanctioned and unwanted programs.  Programs and Features/Software center <a href="#software">System Updates &amp; Software</a>

<input type="checkbox" id="badservice3">Stop and disable unauthorized services <a href="#services">Services & Processes</a>
    o run netstat -ant and check for listening services.  Check your services file to see what ports map to what services
        Linux: /etc/services

<input type="checkbox" id="badfile3">Remove unauthorized files (mp3, m4b, .aa, .mkv, .m4r) (did you do forensics first?!) <a href="#filesystem">File System</a>
<input type="checkbox" id="hacking3">Remove hacking tools (nmap, rainbowcrack, ophcrack,*crack*, xhydra, wireshark, openvpn, betternetVPN, *sploit*) (did you do forensics first?!) <a href="#filesystem">File System</a>
<input type="checkbox" id="remote3">Set remote access related settings (openSSH) defined in README (see policy section) <a href="#secpol">Security Policy</a>

<a href = "LinuxChecklist.txt">Other Checklist and useful commands</a>
</div>
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="software">System Software &amp; Updates</h2>
<pre>
!!!!!!!!! <strong style="color:Tomato;">Start your updates early so they have time to finish</strong> !!!!!!!!!!!

Start 'Software &amp; Updates' and check settings
  Ubuntu 18: Show Applications in left navigation bar -&gt; Software &amp; Updates  
    On the 'Updates' tab
      Check the 'Important and Recommended' options
      Set Automatic updates to 'Daily' and start your OS and program updates (may not get all updates if these settings are not in place)   

Run 'Software Updater' to install all application updates
  Ubuntu 18: Show Applications in left navigation bar -&gt; Software Updater
    
    CLI: sudo apt-get update &amp;&amp; apt-get upgrade -y

    When you run the updates, it updates all the packages installed via apt. This means updating Ubuntu will update the core operating system, 
    Linux kernels as well as the applications installed from the software center (if they were apt packages) or installed using apt command.
        "update" - gets information about new and updated packages
       "upgrade" - installs the newest versions of all packages currently installed on the system

Remove unauthorized software and programs
  Software Center.  Look at all software installed.  Search for and remove any unauthorized
    sudo apt-get remove &lt;software&gt;  (e.g. sudo apt-get remove samba)
    sudo apt-get remove --purge &lt;software&gt; (to purge all config files and ensure it is installed fresh).

Update any required software as listed in the README
	Typically, you can open the software application and find under Help->About and get the current version.  Then Google for the software and check for the lastest version.
	
Undersirable programs
    telnet, rlogind, rshd, rcmd, rexecd, rbootd, rquotad, rstatd, rusersd, rwalld, rexd, fingerd

<em>Possible</em> undesirabale programs (check against the README)
    samba, postgresql, sftpd, tftpd, vsftpd, apache, apache2, ftp, mysql, php, snmp, pop3, sendmail, dovecot, bind9, nginx, x11vnc, nfs, xinetd
	
Check for "Hacking Tools"
    john, nmap, vuze, frostwire, kismet, freeciv, minetest, minetest-server, medusa, hydra, truecrack, ophcrack, nikto, cryptcat, nc, netcat, tightvncserver

Install rootkit and malware scanning tools
    sudo apt-get install -y chkrootkit rkhunter
    # rkhunter usage:
    sudo rkhunter --update
    sudo rkhunter --propupd
    sudo rkhunter -c --enable all --disable none
    # chkrootkit usage:
    sudo chkrootkit -q
    # Visit http://www.chkrootkit.org/README for more
    
    # clamav usage:
    # Update clamav
        sudo freshclam
    # Scan a directory recursively and ring a bell if something is found
    clamscan -r --bell -i /home/user/
    # Scan the whole system (NOT recommended!)
    clamscan -r --remove /
    # Safest option:
    sudo apt-get install clamtk
    sudo clamtk

Check your OS version
  lsb_release -a 

To check for installed packages
  CLI: sudo apt list --installed
 </pre>
<a href="#toc">back to toc</a></br>
<h2 id="filesystem">File System </h2>
<pre>

Show hidden files from within file explorer (this may help you find forensic answers)
  Open the file explorer (drawer icon)
  Go to the top menu ---&gt; View -&gt; Show hidden files
  OR 
Application -&gt; Accessories -&gt; Files -&gt; (gear icon) -&gt; Preferences
  OR
Open file explorer and hit ctrl-H
  CMD: ls -a

Check for shares (this requires that the SAMBA service is running.  It may not be in the competition image and you will get an error.  Thats OK)
   smbstatus --shares

Get file hash value
    sha1sum {file} or md5sum {file}

Ubuntu Base64 decode
    cat &lt;filename&gt; | base64 -d
    
Check actual file type of a file. Checks magic byte to determine true file type
  file &lt;filename&gt;

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

Look in the users home directory for their HISTORY file. You might find some interesting commands.
    cat /home/&lt;user&gt;/.bash_history

Look in the users trash folder in their home directory for deleted files. You might find something interesting.
    TODO: where is the trash for a specific users
    Ubuntu 20: cat /home/username/.local/share/Trash
    Ubuntu 22: TODO: where is this trash folder?
    
Find files (this may help you find forensic answers)
  sudo find &lt;path&gt; &lt;pattern&gt; (the -iname option makes it case insensitive)
  sudo find /home -iname *.mp3
  sudo find /home -iname nmap*.*
  sudo find /home -iname wireshark*.*
  sudo find /home -iname *netcat*
  sudo find /home -iname nc*
 
 Do them all at once:
    sudo find / -type f \( -iname "*.mp3" -o -iname "nc*" -o -iname "nmap*" -o -iname "*shark*" -o -iname "*netcat*" -o -iname "*.pl" -o -iname "*ghidra*" \)

 Tilde (~): Specifies the active user's home directory.
    sudo find ~ -iname &lt;filename&gt;
 Period (.): Specifies the current and all nested folders.
    sudo find . -iname &lt;filename&gt;
 Forward Slash (/): Specifies the entire filesystem. 
    sudo find / -iname &lt;filename&gt;
                
    find / -iname '*searchstring*': Searches the file system for a file that includes searchstring in its name.
    find / -iname '*searchstring*' -exec rm {} \; 
        Searches the file system for a file that includes searchstring in its name and deletes it with the rm command. 
        The backslash and semicolon symbolize the end of the -exec section.
    find / -type f -size 64c -exec base64 -d {} \;
        find a file that is 64bytes in size and run it through base64 decode.

OR use the locate command
  locate *.mp3
    The locate command is the quickest way to find the locations of files and directories in Kali. 
    In order to provide a much shorter search time, locate searches a built-in database named locate.db 
    rather than the entire hard disk itself. This database is automatically updated on a regular basis by 
    the cron scheduler. To manually update the locate.db database, you can use the updatedb command.

    kali@kali:~$ sudo updatedb

    kali@kali:~$ locate sbd.exe
        usr/share/windows-resources/sbd/sbd.exe


To find all *.pl (perl files) file belonging to a user:
  find /var/www -user &lt;username&gt; -name "*.pl"

Check for prohibited files
    # You MUST paste this into a bash or sh file to run.
    for ext in mp3 txt wav wma aac mp4 mov avi gif jpg png bmp img exe msi bat sh
    do
      sudo find /home -name *.$ext
    done

Look for files containing sensitive information, such as credit card numbers, usernames, passwords etc. (they can even be simple .txt files)
    Look in /home &lt;username&gt; Downloads, Documents, Music, Video.
        grep -R &lt;pattern&gt; /&lt;directory&gt;
        grep -R password /home
        
        (-r, recursive. -R recursive and follows symlinks)

File permissions  
    /etc/passwd  
        Owned by Root  
        Read only to users  
    /etc/shadow  
        Owned by Root  
        Users should not have access to this file

Take ownership of a file or folder
    chown username:username &lt;filename&gt;
    chown -R username:username &lt;folder&gt;  (the -R will recurse down the structure)
    
Check file attributes (is there something that keeps you from deleting a file?)
    lsattr &lt;filename&gt;
    Example output: --------------e--- file1.txt

    The letters 'aAcCdDeijPsStTu' select the new attributes for the files:
       append only (a), no atime updates (A), compressed (c), no copy on write
       (C), no dump (d), synchronous directory updates (D), extent format (e),
       immutable (i), data journalling  (j),  project  hierarchy  (P),  secure
       deletion  (s),  synchronous  updates  (S),  no tail-merging (t), top of
       directory hierarchy (T), and undeletable (u).

       The following attributes are read-only, and may be listed by  lsattr(1)
       but  not  modified by chattr: encrypted (E), indexed directory (I), and
       inline data (N).

Network File System (NFS) Security  
    Method of sharing access to a filesystem between Unix systems  
    Only run NFS as needed, apply latest patches (including nfsd, mountd, statd, lockd)
    Careful use of /etc/exports  
    Read only if possible
    
LiSt Open Files (LSOF) is a Linux utility that allows you to view current network connections and the files associated with them.
  lsof

File hash
  md5sum &lt;filename&gt;
  sha1sum &lt;filename&gt;
  sha256sum &lt;filename&gt;

base64 decode
  echo &lt;text string&gt; | base64 -d
  example: echo Q3liZXJwYXRyaW90WElJSQo= | base64 -d
           cat &lt;base64 encoded file&gt; | base64 -d

Change owner of a file or directory
    chown &lt;username&gt; &lt;filename&gt;
    chown &lt;username&gt; &lt;directory&gt;
    
Change group access to file or directory
    chgrp &lt;group&gt; &lt;directory&gt;

Look for a file in users home directory called ./privesc.
  Example: -rwsr-xr-x 1 root    root    8392 Sep  6 11:37 privesc*
    Does it have a Set User ID permission? (the "s" in the permissions set)
    Set User ID is a type of permission that allows users to execute a file with the permissions of a specified user. Those files which have SUID permissions run with higher privileges.
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="secpol">Policy Settings</h2>
<pre>
Secure settings in /etc/ssh/sshd_config
  sudo gedit /etc/ssh/sshd_config

    Protocol 2
    LogLevel VERBOSE
    X11Forwarding no
    MaxAuthTries 4
    IgnoreRhosts yes
    HostbasedAuthentication no
    PermitRootLogin no
    PermitEmptyPasswords no
    PasswordAuthentication no

The SSH daemon must be restarted for the changes to take effect. To restart the SSH daemon, run the following command:
    $ sudo systemctl restart sshd.service

Install and Enable auditing
  Install: sudo apt-get install auditd audispd-plugins
  Enable : sudo systemctl enable auditd
  At this point, Auditd is running and should be writing records to /var/log/audit/audit.log
  
  To verify: sudo cat /var/log/audit/audit.log or sudo tail -f /var/log/audit/audit.log (will watch the log in realtime)

	[optional]
	If you want to configure Auditd to watch a particular directory for file for changes, add rules to audit 
	sudo gedit /etc/audit/rules.d/audit.rules
	   add these lines to the bottom of the file:
	-w /etc/shadow -p wa -k shadow_file_change
	-w /etc/passwd -p wa -k passwd_file_change
	-w /etc/group -p wa -k group_file_change
	-w /etc/sudoers -p wa -k sudoers_file_change

  You must stop and start auditd sevice to read the file: 
     sudo systemctl [stop | start] auditd
 
   See reference: <a href="https://googlethatforyou.com?q=auditd%20linux">Google auditd config</a>

Secure sysctl (NOTE: before you set these, make a backup copy of the existing /etc/sysctl.conf)
    sysctl  is  used  to  modify  kernel parameters at runtime.  
    The parameters available are those listed under /proc/sys/.  Procfs is required for sysctl support in Linux.
    
    man sysctl for complete details

View the sysctl.conf and look at the commented (#) lines for each of the following.
	
	sudo cat /etc/sysctl.conf | more

    sudo sysctl -w net.ipv4.tcp_syncookies=1
    sudo sysctl -w net.ipv4.ip_forward=0
    sudo sysctl -w net.ipv4.conf.all.send_redirects=0
    sudo sysctl -w net.ipv4.conf.default.send_redirects=0
    sudo sysctl -w net.ipv4.conf.default.accept_redirects=0
    sudo sysctl -w net.ipv4.conf.all.secure_redirects=0
    sudo sysctl -w net.ipv4.conf.default.secure_redirects=0

    Now reload the sysctl tool to activate the changes.
        sudo sysctl -p

    You may now see all the active sysctl rules on your Linux system.
        sudo sysctl –a
 </pre>
<a href="#toc">back to toc</a></br>
<h2 id="lusrmgr">Local User Management</h2>
<pre>
Check for unauthorized admins
    cat /etc/group | grep sudo

Check /etc/sudoers and /etc/sudoers.d for unauthorized users and groups.
    Remove any instances of nopasswd and !authenticate, these allow sudo use without authentication
    Any commands listed can be run without a password (ex: /bin/chmod)
    Group lines are preceded by %

Check sudoers requires password
    cat /etc/sudoers
    &lt;username&gt; ALL=NOPASSWD: ALL (make sure this line does not exist)

List users and check for unauthorized users and remove them.  Also check for correct Administrators as listed in README.
  CLI: ls -al /home
  CLI: sudo cat /etc/passwd
  CLI: sudo cut -d: -f1 /etc/passwd
  CLI: id &lt;username&gt;
  GUI: Applications -&gt; System Tools -&gt; Administration -&gt; User Accounts (highlight user and hit "-" to remove)

Delete user (deluser -h for help)
  sudo deluser --remove-home --remove-all-files

Set strong passwords if weak ones are listed in README.  User our default "BoiseBee#1"
  sudo passwd &lt;username&gt; BoiseBee#1
  
  for user in $(ls /home | grep -v &lt;except_this_user&gt;); do sudo passwd $user BoiseBee#1; done
  
  
To list all groups: (verify admins are in the sudo line and standard users are not.)
  sudo cat /etc/group

To add a group if needed: 
  sudo addgroup [groupname]
  
Add user to group: 
  sudo adduser [username] [groupname]
  sudo gpasswd -a [username] [groupname]
  OR
  sudo usermod -a -G &lt;groupname &lt;username&gt;

Remove user from group
  sudo deluser [username] [groupname]
  sudo gpasswd -d [username] [groupname]
  
Review and edit lightdm.conf 
  sudo /usr/lib/lightdm/lightdm-set-defaults -l false
  OR
  sudo gedit /etc/lightdm/lightdm.conf
   Add this line to the end of the Light DM file: 
   allow-guest=false 
    
    Remove autologin-user=[username] (if it exists in 

Password policy
  Install a needed module:
   sudo apt-get install libpam-cracklib

   sudo gedit /etc/pam.d/common-password
    Add to end of line that has pam_unix.so in it: remember=5 minlen=10
    Add to the end of the line with pam_cracklib.so in it: ucredit=-1 lcredit=-1 dcredit=-1 ocredit=-1
 
    See also for reference: http://www.deer-run.com/~hal/sysadmin/pam_cracklib.html

   sudo gedit /etc/pam.d/common-auth
    Add this line to the end of the file: 
    auth required pam_tally2.so deny=5 onerr=fail unlock_time=1800

    sudo gedit /etc/login.defs
     PASS_MAX_DAYS 90
     PASS_MIN_DAYS 10
     PASS_WARN_AGE 7

   Optionally, you can change individual user as follows:
     sudo chage -M 90 -m 10 -W 7 &lt;username&gt;

Check if a user account is locked: sudo passwd -S &lt;username&gt;
                Unlock an account: sudo usermod -U &lt;username&gt;
                
If you need to tell if a user account is allowed to login
    cat /etc/passwd | grep &lt;username&gt;
    if the users shell field is "/usr/sbin/nologin", they are not allowed to login
    
    If the users password field is a *, they are not allowed to login with a password
        Example: root:*:18864:0:99999:7:::

The /etc/shadow file stores your encrypted password. The password hash field has three fields separated by a $.
    Example: student:$6$ymUU64EY$je/RTGaGor5XPJ
        The first field is the hash algorithm used. Different hash algorithms can be used to encrypt your password.

            $1 - MD5
            $2 - Blowfish
            $3 - Eksblowfish
            $4 - NT
            $5 - SHA-256
            $6 - SHA-512
 
Check who is logged in
  CLI: who
 
Make user and group mgmt easier:
  sudo apt-get install gnome-system-tools

So how do you differentiate between a real user and a system process?
The ID number will be the tell. Your own account in the list should look something like "username:x:1000:1000:Firstname Lastname,,,:/home/username:/bin/bash."
That number, 1000, is your ID number. Human users will have an ID number of 1000 or higher. The others should all have ID numbers below 1000.

To disable the root login. This will lock the root account.
    sudo passwd -l root
    
    sudo usermod -U &lt;username&gt; to unlock
 </pre>
<a href="#toc">back to toc</a></br>
<h2 id="network">Network Security</h2>
<pre>
Turn on firewall
  sudo ufw enable
  sudo ufw logging on
  sudo ufw status
  sudo ufw ? to get help
  (optional) To install a GUI: sudo apt-get install gufw

    Simple rule syntax for UFW is as follows:
    sudo ufw &lt;allow|deny&gt; &lt;service_name|port_number|port_number_with_protocol&gt;
    Example: sudo ufw allow ssh OR sudo ufw allow 22 OR sudo ufw allow 22/TCP
    
Check for LISTENING services. (stop and/or remove any unsanctioned services e.g. web server port 80 or 443)
  netstat -ant
  netstat -antp (the p option will show programs associated with that connection)
  netstat -h (for help on the various switches)

  Also check for listening ports that are uncommon yet associated to a valid service.  
    For example, port 8000 on a web server.  Should that be listening? Maybe, maybe not. Check the Readme.
    
    Example of Netcat opening a port 1234 to listen on (could be any port number)
        student@desktop:~$ sudo netstat -pant
        Active Internet connections (servers and established)
        Proto Recv-Q Send-Q Local Address           Foreign Address         State       PID/Program name    
        tcp        0      0 0.0.0.0:1234            0.0.0.0:*               LISTEN      4014/nc      
 
  Note: 127.0.0.1:631 is the primary mechanism for Ubuntu printing and print services is the Common UNIX Printing System (CUPS). - OK
         127.0.0.53:53 local nameserver - OK

Verify the hosts file has only default entries in it and nothing unusual
    /etc/hosts
    
Check your network interfaces.  Anything unusual? Extra interfaces? (typical "ens01", "lo")
    ifconfig
    ip addr
 </pre>
<a href="#toc">back to toc</a></br>
<h2 id="services">Services and Processes</h2>
<pre>
Check for Startup and Scheduled Applications 
    Show Applications -&gt; Startup Applications
        uncheck anything that looks unusual or malicious
		
		Other ways to check for automatic startup items
		ls -l /etc/init.d
		crontab -l
		systemctl list-unit-files | grep enabled 
		less /home/[username]/.bashrc

Stop unauthorized services
# DO NOT STOP ALL OF THESE WITHOUT READING THE README OR UNDERSTANDING WHAT YOU'RE ABOUT TO DO!
    sudo service sshd stop
    sudo service telnet stop # Remote Desktop Protocol
    sudo service vsftpd stop # FTP server
    sudo service snmp stop # Type of network management service
    sudo service pop3 stop # Type of email server
    sudo service icmp stop # Router communication protocol
    sudo service sendmail stop # Type of email server
    sudo service dovecot stop # Type of email server
    
Check the status of a service
  sudo service --status-all
  service --status-all | grep "+" # shows programs with a return code of 0 (C/C++ users will understand), which is 

  (+ = running, - = stopped service. ? = managed by upstart)
  sudo service status ssh &lt;or any other service name&gt;

Typical services running on clean Ubuntu build ( ones with "+" are running and typically set to auto start)
cyberpatriot@ubuntu:~$ sudo service --status-all | grep "+"
 [ + ]  acpid
 [ + ]  anacron
 [ + ]  apparmor
 [ + ]  apport
 [ + ]  avahi-daemon
 [ + ]  bluetooth
 [ + ]  cron
 [ + ]  cups
 [ + ]  cups-browsed
 [ + ]  dbus
 [ + ]  gdm3
 [ + ]  irqbalance
 [ + ]  kerneloops
 [ + ]  kmod
 [ + ]  network-manager
 [ + ]  open-vm-tools
 [ + ]  openvpn  # check the README on this one
 [ + ]  procps
 [ + ]  rsyslog  # standard logging
 [ + ]  udev
 [ + ]  ufw  # firewall

AND/OR

    systemctl list-units --type=service --all
        gives the following output:
          accounts-daemon.service                               loaded active running Accounts Service                                               &gt;
          acpid.service                                         loaded active running ACPI event daemon                                              &gt;
          alsa-restore.service                                  loaded active exited  Save/Restore Sound Card State                                  &gt;
          apparmor.service                                      loaded active exited  Load AppArmor profiles                                         &gt;
          apport.service                                        loaded active exited  LSB: automatic crash report generation                         &gt;
          avahi-daemon.service                                  loaded active running Avahi mDNS/DNS-SD Stack                                        &gt;
          binfmt-support.service                                loaded active exited  Enable support for additional executable binary formats        &gt;
          blk-availability.service                              loaded active exited  Availability of block devices                                  &gt;'
          bluetooth.service                                     loaded active running Bluetooth service

Check config files for important services listed in the README(MySQL, SSH, Apache, FTP etc.)

Service Masking (TODO: More research required)
    Look for masked services. Look for odd service names.
    systemctl unmask &lt;service_name&gt;

Stop a service
  sudo service stop &lt;servicename&gt;

Restart a service only if you need to to restore functionality: 
  sudo service restart &lt;servicename&gt;

Secure openVPN service (if README says that is a required service)
    TODO: research best practice for this
    Look for keys, algorithms and key exchange algoriths (e.g. diffie-hellman)

Install SSH server (only if the README indicates it is needed)
  sudo apt-get install openssh-server
  sudo apt-get install openssh-client (only if needed, should already have a native client)

If FTP or SFTP is listed in the readme as a needed service, install as follows:
FTP(21) / SFTP (22)  
  sudo apt-get install vsftpd  
  config file = /etc/vsftpd.config  
  FTP root dir = /home/&lt;username&gt;
   # Allow anonymous FTP? (Disabled by default).
   anonymous_enable=NO
   # Uncomment this to allow local users to log in.
   local_enable=YES
   # Uncomment this to enable any form of FTP write command.
   write_enable=YES

If the README specifies it, harden VSFTPD FTP service
    # Disable anonymous uploads
    sudo sed -i '/^anon_upload_enable/ c\anon_upload_enable no' /etc/vsftpd.conf
    sudo sed -i '/^anonymous_enable/ c\anonymous_enable=NO' /etc/vsftpd.conf
    # FTP user directories use chroot
    sudo sed -i '/^chroot_local_user/ c\chroot_local_user=YES' /etc/vsftpd.conf
    sudo service vsftpd restart

List and check for valid running processes (look for unique paths and items e.g. /bin/ccups -l -p 2013)
  ps -ef
  ps -aux

Trace an existing process.  Attaching to an existing process requires that you know the process id (pid).  
The easiest way to determine this is to run ‘ps -ef’ and find the root process id of the application in question.
  strace -r -f -p &lt;pid&gt; 
 </pre>
<a href="#toc">back to toc</a></br>
<h2 id="browser">Browser Settings</h2>
<pre>
Firefox browser General settings
  Set to automatically installs updates
  Update to latest version ( may need to run a few times)
  Set as default browser
  
  You can also set the default browser in the Ubuntu <strong>System Preferences</strong>
    Launch System Preferences in your system, either from the tiny gear icon on the top right, the gear icon on your launch bar
	or through searching and entering its name. Then make sure you’re looking at
	“Details” -> “Default Applications” and review all your settings
 
Privacy &amp; Security
  Block pop-ups
  Warn you when websites try to install add-ons
  Block dangerous and deceptive content

Check for unusual add-ons (about:addons)
  Extentions and Plugins
  Settings -&gt; Extensions &amp; Themes

Check all other third party security policy settings
  Extentions and plug-ins
  Settings -&gt; Extensions &amp; Themes
  
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="logs">Log Files and PCAP files </h2>
<pre>
Where and how to look at logs of interest (System, Apache, FTP etc.)
	
Configure the Syslog daemon to log messages and events located at the /etc/syslog.conf 

    /var/log - main log directory
  Most common   
    /var/log/auth.log - authentication related events
    /var/log/faillog - failed login attempts
    /var/log/cron - records information on cron jobs
    /var/log/syslog on Debian systems
  
  Others of interest
    /var/log/messages - generic system activity
    /var/log/kern.log - information logged by the kernel
    /var/log/boot.log - booting related information
    /var/log/dmesg - hardware devices and their drivers are logged here.

Apache web server
    /var/log/apache2
    /var/log/httpd (error and access logs)
    
FTP server logs
    /var/log/ftp.log
    /var/log/syslog

 Firewall logs
    /var/log/ufw*

Read a PCAP file
    tcpdump -r &lt;filename.pcap&gt; | grep &lt;string&gt;
    example: tcpdump -r tcpdumpep1.pcap | grep RETR (looks for file retrival).
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="misc">Misc. Security</h2>
<pre>
Check scheduled tasks: (look for unusual or odd looking jobs)
    sudo ls -al /var/spool/cron/crontabs/
    sudo crontab -l
    
Delete a users crontab
    sudo crontab -r

Check /etc/rc.local for bootup backdoors
 Quickly remove contents of /etc/rc.local
    echo "exit 0" &gt; /etc/rc.local

Check init files in /etc/init/ and /etc/init.d/ for unwanted entries

Stegonography (sudo apt-get install outguess) To extract data from a jpg image
  outguess -r -k koifisharebeautiful! /media/kali/0CC4646CC46459CA/dougs_koi_pond.jpg /tmp/test.txt
</pre>
<a href="#toc">back to toc</a></br>
<h2 id="locations">Common File Locations</h2>
<pre>
    /bin - basic programs (ls, cd, cat, etc.) 
    /sbin - system programs (fdisk, mkfs, sysctl, etc) 
    /etc - configuration files 
    /tmp - temporary files (typically deleted on boot) 
    /usr/bin - applications (apt, ncat, nmap, etc.) 
    /usr/share - application support and data files
    /var - variable data like system log files, mail and printer spool directories, and transient and temporary files. 	
	
	FTP home - possibly in one of these locations
		/ftphome
		/opt/ftphome
		/var/ftphome
	FTP config
        /etc/vsftpd (may be another ftp service like pure-ftpd.  Just look for a *ftp* dir.)
		
	WWW home
	    /var/www/html
		
	openVPN config
	    /etc/openvpn
</pre>
<a href="#toc">back to toc</a></br>
</body>
</html>
