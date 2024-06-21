create database acad_agenda;

use acad_agenda;

create table cadastro(
id int primary key not null auto_increment,
nome char(69) not null,
email varchar(69) not null,
senha varchar(255) not null
); 


CREATE TABLE horarios_disponiveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dia DATE NOT NULL,
    hora TIME NOT NULL,
    disponivel BOOLEAN DEFAULT 1
);

drop table horarios_disponiveis;

select * from cadastro;

select * from horarios_disponiveis;

drop table cadastro;

CREATE TABLE musculos (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    musculo char(20),
    nome CHAR(69)
);

select * from musculos;

drop table musculos;


CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES cadastro(id) ON DELETE CASCADE
);



select * from agendamentos;

drop table agendamentos;
