CREATE TABLE countries
(
    id   INT          NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,

    PRIMARY KEY (id)
)