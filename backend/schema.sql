
-- Creating the users table

create table users(id int not null primary key auto_increment, fname varchar(100) not null, email varchar(100) not null unique, phno varchar(100) not null, dob date, password varchar(100) not null);


-- Testing for the insertion

insert into users(fname, email, phno, dob, password) values ('Sairaj', 'sai@gmail.com', '8999315690', '2004-02-22', 'sai2204t');