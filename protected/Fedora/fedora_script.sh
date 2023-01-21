#!/bin/bash
#installation of programs

sudo dnf install ufw -y -qq 
sudo dnf install auditd audispd-plugins -y -qq 
sudo dnf install libpam-cracklib -y -qq 
sudo dnf install tree -y -qq


#firewall settings 
sudo ufw enable
sudo ufw logging on
sudo ufw deny 1337

#disabling root account 
sudo passwd -l root
sudo usermod -L root

sudo mkdir -p /home/$USER/Desktop/backups

#sets /etc/hosts to default
sudo cp /etc/rc.local /home/$USER/Desktop/backups
sudo chmod 777 /etc/rc.local
sudo echo > /etc/rc.local 
echo 'exit 0' >> /etc/rc.local 
sudo chmod 644 /etc/rc.local

#makes /etc/passwd to correct permissions 
sudo cp /etc/passwd /home/$USER/Desktop/backups
sudo chown -R root:root /etc/passwd
sudo chmod 644 /etc/passwd
sudo chown -R root:root /etc/passwd-
sudo chmod 644 /etc/passwd-
sudo auditctl -w /etc/paswd -p rwa

#makes /etc/shadow to correct permissions 
sudo cp /etc/shadow /home/$USER/Desktop/backups
sudo chown -R root:root /etc/shadow
sudo chmod 000 /etc/shadow
sudo chown -R root:root /etc/shadow-
sudo chmod 000 /etc/shadow-

#makes /etc/group to correct permissions 
sudo cp /etc/group /home/$USER/Desktop/backups
sudo chown -R root:root /etc/group
sudo chmod 644 /etc/group
sudo auditctl -w /etc/group -p rwa

#makes /etc/gshadow to correct permissions 
sudo cp /etc/gshadow /home/$USER/Desktop/backups
sudo chown -R root:root /etc/gshadow 
sudo chmod 000 /etc/gshadow 
sudo chown -R root:root /etc/gshadow-
sudo chmod 000 /etc/gshadow-#chage properties

#makes /etc/fstab to correct permissions 
sudo cp /etc/fstab /home/$USER/Desktop/backups
sudo chown -R root:root /etc/fstab 
sudo chmod 644 /etc/fstab

#makes /etc/sudoers to corrct permissions
sudo cp /etc/sudoers /home/$USER/Desktop/backups
sudo chown -R root:root /etc/sudoers
sudo chmod 440 /etc/sudoers 

#makes .bash_history to correct permissions 
sudo cp .bash_history /home/$USER/Desktop/backups/
sudo chmod 640 .bash_history

#removes all startup scripts 
sudo cp /etc/rc.local /home/$USER/Desktop/backups
sudo echo > /etc/rc.local 
echo 'exit 0' >> /etc/rc.local 

#shellshock vulnerbility 
env i='() { :;}; echo Your system is Bash vulnerable' bash -c "echo Bash vulnerability test"

#irqbalance
sudo cp /etc/default/irqbalance ~/Desktop/backups/
sudo chmod 777 /etc/default/irqbalance
echo > /etc/default/irqbalance
sudo echo -e "#Configuration for the irqbalance daemon\n\n#Should irqbalance be enabled?\nENABLED=\"0\"\n#Balance the IRQs only once?\nONESHOT=\"0\"" >> /etc/default/irqbalance
sudo chmod 644 /etc/default/irqbalance

#audit policies
sudo systemctl enable auditd
sudo auditctl -e 1
sudo cp /etc/audit/rules.d/audit.rules /home/$USER/Desktop/backups
sudo sed -i '$ a -w /etc/shadow -p wa -k shadow_file_change' /etc/audit/rules.d/audit.rules
sudo sed -i '$ a -w /etc/passwd -p wa -k passwd_file_change' /etc/audit/rules.d/audit.rules
sudo sed -i '$ a -w /etc/group -p wa -k group_file_change' /etc/audit/rules.d/audit.rules
sudo sed -i '$ a -w /etc/sudoers -p wa -k sudoers_file_change' /etc/audit/rules.d/audit.rules
sudo service auditd restart 

#clears crontab 
sudo touch /home/$USER/Desktop/backups/user_crontab 
sudo touch /home/$USER/Desktop/backups/root_crontab
sudo chmod 777 /home/$USER/Desktop/backups/user_crontab 
sudo chmod 777 /home/$USER/Desktop/backups/root_crontab

crontab -l > /home/$USER/Desktop/backups/user_crontab 
crontab -r 
sudo crontab -l > /home/$USER/Desktop/backups/root_crontab
sudo crontab -r

cd /etc/
sudo /bin/rm -f cron.deny at.deny
echo root >cron.allow
echo root >at.allow
sudo /bin/chown root:root cron.allow at.allow
sudo /bin/chmod 400 cron.allow at.allow
cd ~


#password policies  
sudo cp /etc/pam.d/common-password /home/$USER/Desktop/backups/
sudo sed -i -e '/pam_unix.so/s/obscure use_authtok/obscure use_authtok remember=5 minlen=10/' /etc/pam.d/common-password
sudo sed -i -e '/pam_cracklib.so/s/retry=3 minlen=8 difok=3/retry=3 minlen=8 difok=3 ucredit=-1 lcredit=-1 dcredit=-1 ocredit=-1/' /etc/pam.d/common-password

<<TODO #FIND PROPER PAM POLICIES
sudo cp /etc/pam.d/common-auth /home/$USER/Desktop/backups/
echo -e "#\n# /etc/pam.d/common-auth - authentication settings common to all services\n#\n# This file is included from other service-specific PAM config files,\n# and should contain a list of the authentication modules that define\n# the central authentication scheme for use on the system\n# (e.g., /etc/shadow, LDAP, Kerberos, etc.).  The default is to use the\n# traditional Unix authentication mechanisms.\n#\n# As of pam 1.0.1-6, this file is managed by pam-auth-update by default.\n# To take advantage of this, it is recommended that you configure any\n# local modules either before or after the default block, and use\n# pam-auth-update to manage selection of other modules.  See\n# pam-auth-update(8) for details.\n\n# here are the per-package modules (the \"Primary\" block)\nauth	[success=1 default=ignore]	pam_unix.so nullok_secure\n# here's the fallback if no module succeeds\nauth	requisite			pam_deny.so\n# prime the stack with a positive return value if there isn't one already;\n# this avoids us returning an error just because nothing sets a success code\n# since the modules above will each just jump around\nauth	required			pam_permit.so\n# and here are more per-package modules (the \"Additional\" block)\nauth	optional			pam_cap.so \n# end of pam-auth-update config\nauth required pam_tally2.so deny=5 unlock_time=1800 onerr=fail audit even_deny_root_account silent" > /etc/pam.d/common-auth
echo -e "#\n# /etc/pam.d/common-password - password-related modules common to all services\n#\n# This file is included from other service-specific PAM config files,\n# and should contain a list of modules that define the services to be\n# used to change user passwords.  The default is pam_unix.\n\n# Explanation of pam_unix options:\n#\n# The \"sha512\" option enables salted SHA512 passwords.  Without this option,\n# the default is Unix crypt.  Prior releases used the option \"md5\".\n#\n# The \"obscure\" option replaces the old \`OBSCURE_CHECKS_ENAB\' option in\n# login.defs.\n#\n# See the pam_unix manpage for other options.\n\n# As of pam 1.0.1-6, this file is managed by pam-auth-update by default.\n# To take advantage of this, it is recommended that you configure any\n# local modules either before or after the default block, and use\n# pam-auth-update to manage selection of other modules.  See\n# pam-auth-update(8) for details.\n\n# here are the per-package modules (the \"Primary\" block)\npassword	[success=1 default=ignore]	pam_unix.so obscure sha512\n# here's the fallback if no module succeeds\npassword	requisite			pam_deny.so\n# prime the stack with a positive return value if there isn't one already;\n# this avoids us returning an error just because nothing sets a success code\n# since the modules above will each just jump around\npassword	required			pam_permit.so\n# and here are more per-package modules (the \"Additional\" block)\npassword	optional	pam_gnome_keyring.so \n# end of pam-auth-update config" > /etc/pam.d/common-password
TODO

#disable su 
#disable su 
sudo cp /etc/pam.d/su ~/Desktop/backups
sudo chmod 777 /etc/pam.d/su
sudo echo -e "#
# The PAM configuration file for the Shadow \`su\' service
#

# This allows root to su without passwords (normal operation)
auth       sufficient pam_rootok.so

# Uncomment this to force users to be a member of group wheel
# before they can use \`su\'. You can also add \"group=foo\"
# to the end of this line if you want to use a group other
# than the default \"wheel\" (but this may have side effect of
# denying \"root\" user, unless she's a member of \"foo\" or explicitly
# permitted earlier by e.g. \"sufficient pam_rootok.so\").
# (Replaces the \`SU_WHEEL_ONLY\' option from login.defs)
auth       required   pam_wheel.so use_uid

# Uncomment this if you want wheel members to be able to
# su without a password.
# auth       sufficient pam_wheel.so trust

# Uncomment this if you want members of a specific group to not
# be allowed to use su at all.
# auth       required   pam_wheel.so deny group=nosu

# Uncomment and edit /etc/security/time.conf if you need to set
# time restrainst on su usage.
# (Replaces the \`PORTTIME_CHECKS_ENAB\' option from login.defs
# as well as /etc/porttime)
# account    requisite  pam_time.so

# This module parses environment configuration file(s)
# and also allows you to use an extended config
# file /etc/security/pam_env.conf.
# 
# parsing /etc/environment needs \"readenv=1\"
session       required   pam_env.so readenv=1
# locale variables are also kept into /etc/default/locale in etch
# reading this file *in addition to /etc/environment* does not hurt
session       required   pam_env.so readenv=1 envfile=/etc/default/locale

# Defines the MAIL environment variable
# However, userdel also needs MAIL_DIR and MAIL_FILE variables
# in /etc/login.defs to make sure that removing a user 
# also removes the user's mail spool file.
# See comments in /etc/login.defs
#
# \"nopen\" stands to avoid reporting new mail when su'ing to another user
session    optional   pam_mail.so nopen

# Sets up user limits according to /etc/security/limits.conf
# (Replaces the use of /etc/limits in old login)
session    required   pam_limits.so

# The standard Unix authentication modules, used with
# NIS (man nsswitch) as well as normal /etc/passwd and
# /etc/shadow entries.
@include common-auth
@include common-account
@include common-session" > /etc/pam.d/su
sudo chmod 644 /etc/pam.d/su


sudo cp /etc/login.defs /home/$USER/Desktop/backups/
sed -i '160s/.*/PASS_MAX_DAYS\o01130/' /etc/login.defs
sed -i '161s/.*/PASS_MIN_DAYS\o0113/' /etc/login.defs
sed -i '162s/.*/PASS_MIN_LEN\o0118/' /etc/login.defs
sed -i '163s/.*/PASS_WARN_AGE\o0117/' /etc/login.defs


#sysctl configurations
sudo cp /etc/sysctl.conf /home/$USER/Desktop/backups/
sudo sed -i '$ a net.ipv4.tcp_syncookies=1' /etc/sysctl.conf
sudo sed -i '$ a net.ipv4.ip_forward=0' /etc/sysctl.conf
sudo sed -i '$ a net.ipv4.conf.all.send_redirects=0' /etc/sysctl.conf
sudo sed -i '$ a net.ipv4.conf.default.send_redirects=0' /etc/sysctl.conf
sudo sed -i '$ a net.ipv4.conf.default.accept_redirects=0' /etc/sysctl.conf
sudo sed -i '$ a net.ipv4.conf.all.secure_redirects=0' /etc/sysctl.conf
sudo sed -i '$ a net.ipv4.conf.default.secure_redirects=0' /etc/sysctl.conf

sudo sysctl -p >>/dev/null

#clears aliases 
unalias -a 

#diables reboot using ctrl alt del
sudo systemctl mask ctrl-alt-del.target
sudo systemctl daemon-reload
cp /etc/init/control-alt-delete.conf /home/$USER/Desktop/backups
sed '/^exec/ c\exec false' /etc/init/control-alt-delete.conf

#users
esudo touch /home/$USER/Desktop/sudo_users 
sudo chmod 777 /home/$USER/Desktop/sudo_users
grep '^sudo:.*$' /etc/group | cut -d: -f4 > /home/$USER/Desktop/temp_sudo_users

sudo touch /home/$USER/Desktop/readme_sudo_users 
sudo chmod 777 /home/$USER/Desktop/readme_sudo_users
echo "Enter ReadMe administrator users with 'spaces' in between"
read -a input
for i in ${input[@]}
do 
	echo $i >> /home/$USER/Desktop/readme_sudo_users
	if grep -wq $i /home/$USER/Desktop/temp_sudo_users; then 
		continue
	else 
		sudo adduser $i wheel
	fi	
	
done

sudo touch /home/$USER/Desktop/sudo_users 
sudo chmod 777 /home/$USER/Desktop/sudo_users
while IFS=',' read -ra arr; do
	for a in ${arr[@]}
		do echo $a >> /home/$USER/Desktop/sudo_users
		if grep -wq $a /home/$USER/Desktop/readme_sudo_users; then 
			continue
		else 
			sudo deluser $a wheel
		fi
	done
done < /home/$USER/Desktop/temp_sudo_users

sudo rm /home/$USER/Desktop/temp_sudo_users
sudo rm /home/$USER/Desktop/readme_sudo_users
sudo rm /home/$USER/Desktop/sudo_users 

	
echo "Did you enter users from README as /home/$USER/Desktop/READMEusers?(y/n)" 
read README



if [ $README = "y" ];
then	
	cat /home/$USER/Desktop/READMEusers | sort > /home/$USER/Desktop/readme
	#sudo rm /home/$USER/Desktop/READMEusers
	sudo chmod 777 /home/$USER/Desktop/READMEusers
	sudo touch /home/$USER/Desktop/users
	sudo chmod 777 /home/$USER/Desktop/users
	awk -F: '($3 >= 1000 && $3 <= 60000) {printf $1"\n"}' /etc/passwd | sort > /home/$USER/Desktop/users
com	
diff -y /home/$USER/Desktop/readme /home/$USER/Desktop/users
echo "DELETE ALL UNAUTHORIZED USERS IN A NEW TERMINAL" 

fi
 
echo "Finished? (y/n)" 
read result 
if [ $result = 'y' ]
then
 continue 
fi 

sudo rm /home/$USER/Desktop/readme
sudo rm /home/$USER/Desktop/users

filename=/home/$USER/Desktop/passwords
n=1 
while read line; do 
if [ $line != $USER ]
then 
	 sudo chage -M 40 -m 5 -W 7 $line
else 
	continue
fi
n=$((n+1))

#passwords
awk -F: '($3 >= 1000 && $3 <= 60000) {printf $1"\n"}' /etc/passwd | sort > /home/$USER/Desktop/passwords
filename=/home/$USER/Desktop/passwords
n=1 
while read line; do 
if [ $line != $USER ]
then 
	 echo -e "BoiseBee#1\nBoiseBee#1" |sudo passwd $line
else 
	continue
fi
n=$((n+1))
done < $filename

#misc. 
echo "exit 0" > /etc/rc.local
sudo dnf update openssl libssl-dev 
sudo dnf-cache policy openssl libssl-dev

echo "what critical services are required? (ssh, ftp, dns, samba, mysql, http, smtp)"
read service 

if [ $service = 'ssh' ]
then 
	echo 'did you do all forensics questions related to ssh? ex. keys, (y/n)'
	read answer 
	if [ $answer = 'y' ]
	then 
		continue
	fi
	sudo ufw allow 22 
	sudo ufw allow ssh 
	sudo cp /etc/ssh/sshd_config /home/$USER/backups
	sudo chmod 777 /etc/ssh/sshd_config
	sudo echo -e "# This is the sshd server system-wide configuration file.  See\n
		# sshd_config(5) for more information.

		# This sshd was compiled with PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin/			 		usr/bin:/sbin:/bin:/usr/games

		# The strategy used for options in the default sshd_config shipped with
		# OpenSSH is to specify options with their default value where
		# possible, but leave them commented.  Uncommented options override the
		# default value.
		
		Include /etc/ssh/sshd_config.d/*.conf
		
		Protocol 2
		Port 7482
		#AddressFamily any
		#ListenAddress 0.0.0.0
		#ListenAddress ::
		
		#HostKey /etc/ssh/ssh_host_rsa_key
		#HostKey /etc/ssh/ssh_host_ecdsa_key
		#HostKey /etc/ssh/ssh_host_ed25519_key
		
		# Ciphers and keying
		#RekeyLimit default none
		
		# Logging
		#SyslogFacility AUTH
		LogLevel VERBOSE
		
		# Authentication:
		
		LoginGraceTime 60
		PermitRootLogin No
		StrictModes yes
		MaxAuthTries 3
		MaxSessions 10
		
		#PubkeyAuthentication yes
		
		# Expect .ssh/authorized_keys2 to be disregarded by default in future.
		#AuthorizedKeysFile	.ssh/authorized_keys .ssh/authorized_keys2
		
		#AuthorizedPrincipalsFile none
		
		#AuthorizedKeysCommand none
		#AuthorizedKeysCommandUser nobody
		
		# For this to work you will also need host keys in /etc/ssh/ssh_known_hosts
		#HostbasedAuthentication no
		# Change to yes if you don't trust ~/.ssh/known_hosts for
		# HostbasedAuthentication
		#IgnoreUserKnownHosts no
		# Don't read the user's ~/.rhosts and ~/.shosts files
		IgnoreRhosts yes
		
		# To disable tunneled clear text passwords, change to no here!
		PasswordAuthentication no
		PermitEmptyPasswords no
		
		# Change to yes to enable challenge-response passwords (beware issues with
		# some PAM modules and threads)
		KbdInteractiveAuthentication no
		
		# Kerberos options
		#KerberosAuthentication no
		#KerberosOrLocalPasswd yes
		#KerberosTicketCleanup yes
		#KerberosGetAFSToken no
		
		# GSSAPI options
		#GSSAPIAuthentication no
		#GSSAPICleanupCredentials yes
		#GSSAPIStrictAcceptorCheck yes
		#GSSAPIKeyExchange no
		
		# Set this to 'yes' to enable PAM authentication, account processing,
		# and session processing. If this is enabled, PAM authentication will
		# be allowed through the KbdInteractiveAuthentication and
		# PasswordAuthentication.  Depending on your PAM configuration,
		# PAM authentication via KbdInteractiveAuthentication may bypass
		# the setting of 'PermitRootLogin without-password'.
		# If you just want the PAM account and session checks to run without
		# PAM authentication, then enable this but set PasswordAuthentication
		# and KbdInteractiveAuthentication to 'no'.
		UsePAM yes
		
		#AllowAgentForwarding yes
		AllowTcpForwarding no
		#GatewayPorts no
		X11Forwarding no
		#X11DisplayOffset 10
		#X11UseLocalhost yes
		#PermitTTY yes
		PrintMotd no
		PrintLastLog no
		#TCPKeepAlive yes
		#PermitUserEnvironment no
		#Compression delayed
		ClientAliveInterval 300
		ClientAliveCountMax 0
		#UseDNS no
		#PidFile /run/sshd.pid
		MaxStartups 2
		#PermitTunnel no
		#ChrootDirectory none
		#VersionAddendum none
		
		# no default banner path
		#Banner none
		
		# Allow client to pass locale environment variables
		AcceptEnv LANG LC_*
		
		# override default of no subsystems
		Subsystem	sftp	/usr/lib/openssh/sftp-server
		
		# Example of overriding settings on a per-user basis
		#Match User anoncvs
		#	X11Forwarcorwarding no
		#	PermitTTY no
		#	ForceCommand cvs server" > /etc/ssh/sshd_config
		
	sudo chmod 644 /etc/ssh/sshd_config
	sudo systemctl restart ssh
	sudo chown root:root /etc/ssh/ssh_host_ecdsa_key
	sudo chown root:root /etc/ssh/ssh_host_ed25519_key
	sudo chown root:root /etc/ssh/ssh_host_rsa_key
	sudo chown root:root /etc/ssh/ssh_host_ecdsa_key.pub
	sudo chown root:root /etc/ssh/ssh_host_ed25519_key.pub
	sudo chown root:root /etc/ssh/ssh_host_rsa_key.pub
	
	sudo chmod 400 /etc/ssh/ssh_host_ecdsa_key
	sudo chmod 400 /etc/ssh/ssh_host_ed25519_key
	sudo chmod 400 /etc/ssh/ssh_host_rsa_key
	
	sudo chmod 644 /etc/ssh/ssh_host_ecdsa_key.pub
	sudo chmod 644 /etc/ssh/ssh_host_ed25519_key.pub
	sudo chmod 644 /etc/ssh/ssh_host_rsa_key.pub
	
else 
	sudo ufw deny 22 
	sudo ufw deny ssh 
	sudo dnf purge openssh-server -y -qq

fi 	
if [ $service = 'ftp' ]
then 
	sudo ufw allow 21
	sudo ufw allow ftp 
	sudo ufw allow sftp 
	sudo ufw allow saft 
	sudo ufw allow ftps-data 
	sudo ufw allow ftps
	sudo cp /etc/vsftpd/vsftpd.conf ~/Desktop/backups/
	sudo cp /etc/vsftpd.conf ~/Desktop/backups/
	sudo gedit /etc/vsftpd/vsftpd.conf & sudo gedit /etc/vsftpd.conf
	sudo service vsftpd restart

	
else
	sudo ufw deny ftp 
	sudo ufw deny sftp 
	sudo ufw deny saft 
	sudo ufw deny ftps-data 
	sudo ufw deny ftps
	sudo dnf purge vsftpd -y -qq
	sudo ufw deny 21 
	sudo ufw deny 20
	
	
fi 
	
	
if [ $service = 'samba' ]
then 
	sudo ufw allow 139 
	sudo ufw allow 445
	sudo ufw allow netbios-ns
	sudo ufw allow netbios-dgm
	sudo ufw allow netbios-ssn
	sudo ufw allow microsoft-ds
	sudo dnf install samba -y -qq
	sudo dnf install system-config-samba -y -qq
	sudo cp /etc/samba/smb.conf ~/Desktop/backups/
	if [ "$(grep '####### Authentication #######' /etc/samba/smb.conf)"==0 ]
	then
		sudo sed -i 's/####### Authentication #######/####### Authentication #######\nsecurity = user/g' /etc/samba/smb.conf
	fi
	sudo sed -i 's/usershare allow guests = no/usershare allow guests = yes/g' /etc/samba/smb.conf
	
	echo Type all user account names, with a space in between
	read -a usersSMB
	usersSMBLength=${#usersSMB[@]}	
	for (( i=0;i<$usersSMBLength;i++))
	do
		sudo echo -e 'Moodle!22\nMoodle!22' | smbpasswd -a ${usersSMB[${i}]}
	done
else
	
	sudo ufw deny 139 
	sudo ufw deny 445
	sudo ufw deny netbios-ns
	sudo ufw deny netbios-dgm
	sudo ufw deny netbios-ssn
	sudo ufw deny microsoft-ds
	sudo dnf purge samba -y -qq
	sudo dnf purge samba-common -y  -qq
	sudo dnf purge samba-common-bin -y -qq
	sudo dnf purge samba4 -y -qq
	
fi
	
if [ $service = 'mysql' ]
then 
	
	sudo ufw allow ms-sql-s 
	sudo ufw allow ms-sql-m 
	sudo ufw allow mysql 
	sudo ufw allow mysql-proxy
	sudo dnf install mysql-server-5.6 -y -qq
	sudo cp /etc/my.cnf ~/Desktop/backups/
	sudo cp /etc/mysql/my.cnf ~/Desktop/backups/
	sudo cp /usr/etc/my.cnf ~/Desktop/backups/
	sudo cp ~/.my.cnf ~/Desktop/backups/
	if sudo grep -q "bind-address" "/etc/mysql/my.cnf"
	then
		sudo sed -i "s/bind-address\t\t=.*/bind-address\t\t= 127.0.0.1/g" /etc/mysql/my.cnf
	fi
	sudo gedit /etc/my.cnf&gedit /etc/mysql/my.cnf&gedit /usr/etc/my.cnf&gedit ~/.my.cnf
	sudo service mysql restart
else
	sudo ufw deny 3306
	sudo ufw deny ms-sql-s 
	sudo ufw deny ms-sql-m 
	sudo ufw deny mysql 
	sudo ufw deny mysql-proxy
	sudo dnf purge mysql -y -qq
	sudo dnf purge mysql-client-core-5.5 -y -qq
	sudo dnf purge mysql-client-core-5.6 -y -qq
	sudo dnf purge mysql-common-5.5 -y -qq
	sudo dnf purge mysql-common-5.6 -y -qq
	sudo dnf purge mysql-server -y -qq
	sudo dnf purge mysql-server-5.5 -y -qq
	sudo dnf purge mysql-server-5.6 -y -qq
	sudo dnf purge mysql-client-5.5 -y -qq
	sudo dnf purge mysql-client-5.6 -y -qq
	sudo dnf purge mysql-server-core-5.6 -y -qq
	
	
fi 
	
if [ $service = 'http' ] 
then 
	sudo ufw allow 80
	sudo dnf install apache2 -y -qq
	sudo ufw allow http 
	sudo ufw allow https
	sudo cp /etc/apache2/apache2.conf ~/Desktop/backups/
	if [ -e /etc/apache2/apache2.conf ]
	then
  	  sudo echo -e '\<Directory \>\n\t AllowOverride None\n\t Order Deny,Allow\n\t Deny from all\n\<Directory \/\>\nUserDir disabled root' >> /etc/apache2/apache2.conf
	fi
	sudo chown -R root:root /etc/apache2
else 
	sudo ufw deny 80
	sudo ufw deny http
	sudo ufw deny https
	sudo dnf purge apache2 -y -qq
	sudo rm -r /var/www/*
fi
	
if [ $service = 'dns' ]
then 
	sudo ufw allow domain
	sudo ufw allow 53
else 
	sudo ufw deny domain
	sudo dnf purge bind9 -qq
fi

if [ $service = 'smtp' ]
then 
	sudo ufw allow 25
	sudo ufw allow smtp 
	sudo ufw allow pop2 
	sudo ufw allow pop3
	sudo ufw allow imap2 
	sudo ufw allow imaps 
	sudo ufw allow pop3s
else

	sudo ufw deny 25
	sudo ufw deny smtp 
	sudo ufw deny pop2 
	sudo ufw deny pop3
	sudo ufw deny imap2 
	sudo ufw deny imaps 
	sudo ufw deny pop3s
	
	
fi 

echo "Are media files allowed?(y/n)"
read mediaFiles

if [ $mediaFiles = 'n' ]
then 
	sudo touch ~/Desktop/prohibited_files 
	sudo chmod 777 ~/Desktop/prohibited_files 
	
	sudo find / -name "*.midi" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.mid" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.mp3" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.mp2" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.mpa" -type f >> ~/Desktop/prohibited_files 	
	sudo find / -name "*.abs" -type f >> ~/Desktop/prohibited_files 	
	sudo find / -name "*.mpega" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.au" -type f >> ~/Desktop/prohibited_files
	sudo find / -name "*.snd" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.wav" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.aiff" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.aif" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.sid" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.flac" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.ogg" -type f >> ~/Desktop/prohibited_files 
	


	sudo find / -name "*.mpeg" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.mpg" -type f >> ~/Desktop/prohibited_files	
	sudo find / -name "*.mpe" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.dl" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.movie" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.movi" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.mv" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.iff" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.anim5" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.anim3" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.anim7" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.avi" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.vfw" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.avx" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.fli" -type f >> ~/Desktop/prohibited_files 
	
	sudo find / -name "*.flc" -type f >> ~/Desktop/prohibited_files 
	sudo sudo find / -name "*.mov" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.qt" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.spl" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.swf" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.dcr" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.dir" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.dxr" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.rpm" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.rm" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.smi" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.ra" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.ram" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.rv" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.wmv" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.asf" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.asx" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.wma" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.wax" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.wmv" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.wmx" -type f >> ~/Desktop/prohibited_files
	sudo find / -name "*.3gp" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.mov" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.mp4" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.avi" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.swf" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.flv" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.m4v" -type f >> ~/Desktop/prohibited_files 
	
	

	
	sudo find / -name "*.tiff" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.tif" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.rs" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.im1" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.gif" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.jpeg" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.jpg" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.jpe" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.png" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.rgb" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.xwd" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.xpm" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.ppm" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.pbm" -type f >> ~/Desktop/prohibited_files
	sudo find / -name "*.pgm" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.pcx" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.ico" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.svg" -type f >> ~/Desktop/prohibited_files 
	sudo find / -name "*.svgz" -type f >> ~/Desktop/prohibited_files 
	

else 
	continue
fi

<<com
#removes hacking tools 
list=(netcat netcat-openbsd netcat-traditional ncat pnetcat socat sock socket sbd john john-data hydra hydra-gtk aircrack-ng fcrakzip lcrack ophcrack ophcrack-cli pdfcrack pyrit rarcrack sipcrack irpas zeitgeist-core zeutgeist-datahub python-zeitgeist rhythmbox-plugin-zeitgeist zeitgeist wireshark)
echo 'Remove hacking tools,files and crontab? Have you read README and Forensics?(y/n)' 
read hacking
if [ $hacking == "y" ]
then
	for name in ${list[@]};
	do 	
		sudo dnf remove $name 
	done


	
fi
com

sudo rm /usr/bin/nc  
sudo find /bin/ -name "*.sh" -type f -delete



echo "Start Updates?(y/n) Remove Unauthorized programs first to save time!"
read update 
if [ $update = "y"]
then 
	sudo dnf autoremove -y 

	#runs updates
	sudo dnf update -y
	sudo dnf upgrade -y 
	sudo dnf dist-upgrade -y
fi
exit
