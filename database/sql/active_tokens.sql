CREATE TABLE active_tokens
(
    id      INT          NOT NULL AUTO_INCREMENT,
    user_id INT          NOT NULL UNIQUE,
    token   VARCHAR(500) NOT NULL UNIQUE,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
)