create table koormad(
    id int primary key AUTO_INCREMENT,
    autonr varchar(6) unique,
    sisenemismass int,
    lahkumismass int
);