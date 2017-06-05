CREATE USER 'teamart@localhost' IDENTIFIED BY "teamart1234";
create database teamart;
grant all privileges on teamart.* to teamart@localhost identified by 'teamart1234';
flush privileges;