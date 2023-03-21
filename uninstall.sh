#!/bin/sh

#!/bin/sh

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

# This script will stopp runniong Heimdal agent (>3.0.0) and will perform a deep cleaning of all files
# and resources used by our agent.

# The script need to be run with sudo in order to work properly
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

USER_NAME=$(printf '%s' "${SUDO_USER:-$USER}")

if [[ $(/usr/bin/id -u) -ne 0 ]]; then
    log "Not running as root"
    exit
fi


#locations
NEW_AGENT_BASE_PATH="/Users/Shared/.ThorAgent/"
OLD_BASE_PATH="/Library/HeimdalSecurity/"

#license
LOGS_PATH_FOLDER="${OLD_BASE_PATH}/AgentLogs/"
LOGS_PATH="${LOGS_PATH_FOLDER}uninstall.log"

QUARANTINE_BASE_PATH="${OLD_BASE_PATH}Vigilance/Quarantine/"

RELATIVE_LIBRARY_PATH=~/Library/
#keep old logs if exists
if [ -f "$LOGS_PATH" ]
then
    echo "`date`:\n\n\n\n\nStarted new uninstall proccess of HeimdalAgent..." >> $LOGS_PATH
else
    #make sure the path to the  logs folder exist
    mkdir -p $LOGS_PATH_FOLDER
    echo "`date`: Started new uninstall proccess of HeimdalAgent..." > $LOGS_PATH
fi

#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
#     Easily print logs to cli and file
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
log() {
 echo "$1"
 echo "`date`: $1" >> $LOGS_PATH
}


# Stop Launch agent com.heimdalSecurity.Agent.restart.plist
log "Stop Launch agent com.heimdalSecurity.Agent.restart.plist"
sudo -u $USER_NAME launchctl unload /Library/LaunchAgents/com.heimdalSecurity.Agent.restart.plist
# Make sure we close the restart agent for root also
sudo launchctl unload /Library/LaunchAgents/com.heimdalSecurity.Agent.restart.plist
# This will eliminate the needed of restart operation. 
sudo launchctl bootout system/com.heimdalSecurity.Agent.restart.plist

sleep 1

# Remove com.heimdalSecurity.Agent.restart.plist launch agent
log "Remove com.heimdalSecurity.Agent.restart.plist launch agent"
rm -rf "/Library/LaunchAgents/com.heimdalSecurity.Agent.restart.plist"
sleep 1 

# Stop Launch daemon com.heimdalsecurity.heimdalAgent.cmdHelper.plist
log "Stop Launch daemon com.heimdalsecurity.heimdalAgent.cmdHelper.plist"
sudo launchctl unload "/Library/LaunchDaemons/com.heimdalsecurity.heimdalAgent.cmdHelper.plist"
sleep 1

# Remove com.heimdalsecurity.heimdalAgent.cmdHelper.plist launch daemon
log "Remove com.heimdalsecurity.heimdalAgent.cmdHelper.plist launch daemon"
rm -rf "/Library/LaunchDaemons/com.heimdalsecurity.heimdalAgent.cmdHelper.plist"
sleep 1 
# Remove SudoPriviledge helper
log "Remove SudoPriviledge helper"
rm -rf /Library/PrivilegedHelperTools/com.heimdalsecurity.heimdalAgent.cmdHelper


log  "Killing HeimdalAgent process..."
sleep 1
killall "Heimdal Agent"
sleep 1
killall "Heimdal Agent"
sleep 1
log "Heimdal process killed"


# Copy logs  

log "Copy DarkLayer Guard logs to /Library/HeimdalAgent/AgentLogs"
mkdir "${LOGS_PATH_FOLDER}/DNSLogs"
cp -a "${NEW_AGENT_BASE_PATH}/.Logs/." "${LOGS_PATH_FOLDER}/DNSLogs"

log "Copy all logs in /Library/HeimdalAgent/AgentLogs"
mkdir "${LOGS_PATH_FOLDER}/HeimdalLogs"
cp -a "${RELATIVE_LIBRARY_PATH}Application Support/HeimdalLogs/." "${LOGS_PATH_FOLDER}/HeimdalLogs"
rm -rf  $NEW_AGENT_BASE_PATH

# Remve data  
log "Remove stored data for current user"
sudo -u $USER_NAME defaults delete com.heimdalsecurity.heimdalAgent

log "Remove system stored data"
sudo defaults delete com.heimdalsecurity.heimdalAgent

log "Remove app from Applications"
rm -rf "/Applications/Heimdal Agent.app"

log "Heimdal Agent uninstall succesfully"
