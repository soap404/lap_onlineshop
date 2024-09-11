CREATE TABLE addresses
(
    id          INT          NOT NULL AUTO_INCREMENT,
    user_id     INT          NOT NULL,
    country_id  INT          NOT NULL,

    street      VARCHAR(255) NOT NULL,
    plz         VARCHAR(255) NOT NULL,
    home_number VARCHAR(255) NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (country_id) REFERENCES countries (id)
)