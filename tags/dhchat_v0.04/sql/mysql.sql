#This SQL Dump was designed and coded by PieroLas.
#http://www.cmq.it
#design for xoops 2.2 by dhcst http://xoops.dhcst.de

CREATE TABLE dhchat_messages (
  mid int(11) unsigned NOT NULL auto_increment,
  chatroom varchar(50) NOT NULL,
  message text NOT NULL,
  poster varchar(50) NOT NULL,
  toposter varchar(50) NOT NULL,
  post_time int(10) NOT NULL,
  poster_ip varchar(15) NOT NULL,
  PRIMARY KEY (mid)
) TYPE=MyISAM;

CREATE TABLE dhchat_rooms (
  rid int(10) unsigned NOT NULL auto_increment,
  room_name varchar(30) NOT NULL,
  room_type tinyint(1) NOT NULL default '1',
  PRIMARY KEY (rid)
) TYPE=MyISAM;

CREATE TABLE dhchat_whosonline (
  wid int(11) unsigned NOT NULL auto_increment,
  uid int(5) NOT NULL,
  user_roomid int(10) NOT NULL default 0,
  nick varchar(25) NOT NULL,
  user_ip varchar(15) NOT NULL,
	user_session varchar(50) NOT NULL,
  user_time varchar(15) NOT NULL,
  PRIMARY KEY (wid)
) TYPE=MyISAM;

CREATE TABLE dhchat_banned (
  bid int(11) unsigned NOT NULL auto_increment,
  user varchar(25) NOT NULL,
  from_time int(10) NOT NULL,
  to_time int(10) NOT NULL,
  PRIMARY KEY (bid)
) TYPE=MyISAM;

CREATE TABLE dhchat_visibility (
  visid smallint(6) NOT NULL auto_increment,
  rid smallint(6) NOT NULL default 0,
  groupid smallint(6) NOT NULL default 0,
  PRIMARY KEY  (visid)
) TYPE=MyISAM AUTO_INCREMENT=20 ;

INSERT INTO dhchat_rooms VALUES ('','Standard',2);
INSERT INTO dhchat_rooms VALUES ('','Shourtbox',1);
