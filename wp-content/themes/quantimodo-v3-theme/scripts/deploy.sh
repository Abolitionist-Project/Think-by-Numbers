#!/bin/sh

echo This script hasn\'t been set up. Edit it properly.
exit 1

# SSH_SERVER is user@host or whatever else you put after ssh to connect
SSH_SERVER=username@dev.quantimodo.com
# SOURCE_FILE is the full path to ROOT.war on the local machine
SOURCE_FILE=/PATH/TO/qm-java/fluxtream-web/target/ROOT.war
# DESTINATION is the full path to the live ROOT.war (without the .war) on the server
DESTINATION=/mnt/qm-java-env/apache-tomcat-7.0.35/webapps/ROOT
# TOMCAT_BIN is the path to catalina.sh on the server without a trailing slash
TOMCAT_BIN=/mnt/qm-java-env/apache-tomcat-7.0.35/bin

ssh $SSH_SERVER sudo rm -f $DESTINATION.uploading
scp $SOURCE_FILE $SSH_SERVER:$DESTINATION.uploading
ssh $SSH_SERVER "chmod 777 $DESTINATION.uploading; sudo $TOMCAT_BIN/shutdown.sh stop 10 -force || true; sudo mv $DESTINATION.war $DESTINATION.war.bak || true; sudo rm -rf $DESTINATION || true; mv $DESTINATION.uploading $DESTINATION.war; $TOMCAT_BIN/startup.sh"
