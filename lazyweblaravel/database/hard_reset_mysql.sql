/*
    Block
        MySql/MariaDb Hard Reset

    Functionality
        Initialize database to the new schema
        Used only for development
*/

DROP DATABASE IF EXISTS LazyboyServer;

CREATE DATABASE LazyboyServer;
SHOW DATABASES;


USE LazyboyServer;




CREATE TABLE users (
    uid             INT AUTO_INCREMENT PRIMARY KEY,
    firstname       VARCHAR(30) NOT NULL,
    lastname        VARCHAR(30) NOT NULL,
    username        VARCHAR(30) NOT NULL UNIQUE,
    password        CHAR(32)    NOT NULL,
    email           VARCHAR(50) NOT NULL,
    cell            VARCHAR(20) NOT NULL,
    auth_provider   ENUM('Google', 'Kakao', 'None') NOT NULL,
    stream_id       VARCHAR(32) NOT NULL,
    status          ENUM(
                            'DANGER_URGENT_RESPONSE',
                            'DANGER_MEASURED_RESPONSE',
                            'DANGER_PUBLIC_RESPONSE',
                            'FINE'
                    ),
    response        ENUM(
                        'RESPONSE_REQUIRED',
                        'FIRST_RESPONDERS_DISPATCHED',
                        'FIRST_RESPONDERS_ARRIVED',
                        'RESOLVING',
                        'RESOLVED'
                    ),
    privacy         ENUM (
                        'PRIVATE',
                        'LIMITED',
                        'PUBLIC'
                    ),

    password_hint   MEDIUMTEXT NOT NULL,
    hint_answer     VARCHAR(50) NOT NULL,

    CONSTRAINT prevent_duplicate UNIQUE (email, auth_provider),

    INDEX(status, response)

) ENGINE=INNODB;




CREATE TABLE reports (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid                 INT NOT NULL,
    date_report         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status              ENUM(
                                'DANGER_URGENT_RESPONSE',
                                'DANGER_MEASURED_RESPONSE',
                                'DANGER_PUBLIC_RESPONSE',
                                'FINE'
                        ),
    response            ENUM(
                            'RESPONSE_REQUIRED',
                            'FIRST_RESPONDERS_DISPATCHED',
                            'FIRST_RESPONDERS_ARRIVED',
                            'RESOLVING',
                            'RESOLVED'
                        ),
    responders          VARCHAR(200),
    description         MEDIUMTEXT

    /*
    FOREIGN KEY(uid)
        REFERENCES users.(uid)
        ON UPDATE CASCADE
    */
) ENGINE=INNODB;




CREATE TABLE forum_posts (
    post_id         INT AUTO_INCREMENT PRIMARY KEY,
    uid             INT NOT NULL,
    title           VARCHAR(50) NOT NULL,
    author          VARCHAR(20) NOT NULL,
    date            TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    view_count      INT NOT NULL DEFAULT 0,
    contents        MEDIUMTEXT,
    post_root       INT NOT NULL,
    post_parent     INT,

    FOREIGN KEY (uid)
        REFERENCES users(uid)
        ON UPDATE CASCADE

) ENGINE=INNODB;




CREATE TABLE support_request (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    uid             INT NOT NULL,
    type            ENUM (
                        'REPAIR',
                        'TECH_SUPPORT',
                        'REFUND',
                        'LEGAL'
                    ),
    status          ENUM(
                        'PENDING',
                        'RESPONDED',
                        'RESOLVED'
                    ),

    FOREIGN KEY (uid)
        REFERENCES users(uid)
        ON UPDATE CASCADE

) ENGINE=INNODB;




CREATE TABLE guardianships (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid_guardian        INT NOT NULL,
    uid_client          INT NOT NULL,
    accepted_client     BOOLEAN NOT NULL DEFAULT FALSE,
    accepted_guardian   BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE=INNODB;




DROP PROCEDURE IF EXISTS GetUserByEmail;

DELIMITER $$
CREATE PROCEDURE GetUserByEmail (
    IN user_email VARCHAR(50)
)
BEGIN
    SELECT
        firstname,
        lastname,
        username,
        email,
        cell,
        auth_provider,
        stream_id,
        status,
        response

    FROM
        users

    WHERE
        email = user_email;
END $$

DELIMITER ;
