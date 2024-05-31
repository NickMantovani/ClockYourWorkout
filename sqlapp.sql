create database acad_agenda;

use acad_agenda;

create table cadastro(
id int primary key not null auto_increment,
nome char(69) not null,
email varchar(69) not null,
senha varchar(69) not null
); 


CREATE TABLE horarios_disponiveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dia DATE NOT NULL,
    hora TIME NOT NULL,
    disponivel BOOLEAN DEFAULT 1
);

select * from cadastro;

select * from horarios_disponiveis;

drop table cadastro;