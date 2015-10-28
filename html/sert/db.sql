create database PKI ;
use PKI;
create table user(
	id int auto_increment,
	c varchar(4) not null default 'TN',
	st varchar(40) not null,
	l varchar(40) not null,
	o varchar(60) not null,
	ou varchar(40) not null,
	cn varchar(60) not null,
	email varchar(60) not null,
	pw varchar(50) not null,
	tel varchar(30) not null,
	e int(1) not null default 1,
	dtc timestamp default current_timestamp on update current_timestamp,
	primary key(id),
	unique(email)

);

create table demande(
	id int auto_increment,
	uid int not null,
	hash varchar(10) not null,
	len int(4) not null default 1024,
	subj varchar(200) not null,
	t varchar(10) not null,
	d int(5) not null,
	dtc timestamp default current_timestamp on update current_timestamp,
	primary key(id),
	foreign key(uid) references user(id)

);

create table rep(
	id int auto_increment,
	did int not null,
	admin varchar(60) not null,
	repn int(1) not null default 1,
	reps varchar(40) not null default 'ACCEPT',
	comm varchar(500) not null default 'ACCEPT: VALID REQUEST',
	dtc timestamp default current_timestamp on update current_timestamp,
	primary key(id),
	foreign key(did) references demande(id)
);

create table cert(
	id int auto_increment,
	rid int not null,
	admin varchar(30),
	ca mediumblob not null,
	pkey mediumblob not null,
	csr mediumblob not null,
	db mediumblob not null,
	srl int(1) not null default 1,
	crlnumber int(1) not null default 1,
	dtcr date not null,
	dtexp date not null,
	hash varchar(10) not null default 'md5',
	len int(4) not null default 1024,
	opn int(1) not null default 1,
	ops varchar(20) not null default 'NEW',
	subj varchar(200) not null,
	dtc timestamp default current_timestamp on update current_timestamp,
	primary key(id),
	foreign key(rid) references rep(id)
);

create table opp(
	id int auto_increment,
	cid int not null,
	oldca mediumblob not null,
	oldkey mediumblob not null,
	ncsr mediumblob not null,
	nkey mediumblob not null,
	nca mediumblob not null,
	admin varchar(30) not null,
	oppn int(1) not null,
	opps varchar(20) not null,
	dtc timestamp default current_timestamp on update current_timestamp,
	primary key(id),
	foreign key(cid) references cert(id)
);

