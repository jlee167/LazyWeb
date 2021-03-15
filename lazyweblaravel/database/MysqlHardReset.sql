/****************************************************************************
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 *      WARNING   WARNING  WARNING  WARNING  WARNING  WARNING  WARNING      *
 * ----------------------------------------------------------------------   *
 *                THIS DATA SCHEME IS HIGHLY EXPERIMENTAL.                  *
 *  IN NORMAL CIRCUMSTANCES, I WILL NOT BE ASKING ANYTHING MORE THAN YOUR   *
 *                           - USERNAME, PASSWORD                           *
 *                                 - EMAIL                                  *
 *                            - FACESHOT(OPTIONAL)                          *
 * IN MY WEBSITE. REST OF THE PERSONAL DATA WILL BE NULL FOR NORMAL USERS.  *
 * ONLY MY OWN TEST ACCOUNTS WILL BE ABLE TO HAVE DATA ON REST OF FIELDS IN *
 *                               USERS TABLE.                               *
 ****************************************************************************/






/* -------------------------------------------------------------------------- */
/*                         MySql / MariaDb Hard Reset                         */
/* -------------------------------------------------------------------------- */




/* --------------------------------------------------------------------------
    Funtionality
        Initialize database to the new schema.
-------------------------------------------------------------------------- */



DROP DATABASE IF EXISTS LazyboyServer;
CREATE DATABASE LazyboyServer;
SHOW DATABASES;
USE LazyboyServer;




CREATE TABLE users (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    firstname       VARCHAR(30) DEFAULT NULL,
    lastname        VARCHAR(30) DEFAULT NULL,

    username        VARCHAR(60) UNIQUE,
    password        VARCHAR(60),   /* BCRYPT HASH */
    auth_provider   ENUM('Google', 'Kakao', 'None') NOT NULL,
    uid_oauth       VARCHAR(50),

    faceshot_url    VARCHAR(200) DEFAULT NULL,

    email           VARCHAR(50) UNIQUE NOT NULL,
    cell            VARCHAR(20) DEFAULT NULL,
    stream_id       VARCHAR(32) UNIQUE DEFAULT NULL,
    stream_key      VARCHAR(32) NOT NULL, /* Todo: Make Bcrypt Hash */
    status          ENUM(
                        'DANGER_URGENT',
                        'FINE'
                    ) DEFAULT NULL,
    response        ENUM(
                        'RESPONSE_REQUIRED',
                        'FIRST_RESPONDERS_DISPATCHED',
                        'FIRST_RESPONDERS_ARRIVED',
                        'RESOLVING',
                        'RESOLVED'
                    ) DEFAULT NULL,
    privacy         ENUM (
                        'PRIVATE',
                        'LIMITED',
                        'PUBLIC'
                    ) DEFAULT NULL,
    proxy_enable    BOOL DEFAULT NULL,
    password_hint   MEDIUMTEXT DEFAULT NULL,
    hint_answer     VARCHAR(50) DEFAULT NULL,

    CONSTRAINT prevent_duplicate UNIQUE (uid_oauth, auth_provider),

    INDEX(status, response)

) ENGINE=INNODB;





CREATE TABLE cam_ownership (
    cam_id              INT AUTO_INCREMENT PRIMARY KEY,
    owner_uid           INT NOT NULL,
    date_registered     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
    stream_key           VARCHAR(60) NOT NULL,   /* HASHED!!! */
    description         MEDIUMTEXT

    /*
    FOREIGN KEY(uid)
        REFERENCES users.(uid)
        ON UPDATE CASCADE
    */
) ENGINE=INNODB;




CREATE TABLE posts (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    forum           ENUM (
                        'general',
                        'tech'
                    ),
    title           VARCHAR(50) NOT NULL,
    author          VARCHAR(20) NOT NULL,
    date            TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    view_count      INT NOT NULL DEFAULT 0,
    contents        MEDIUMTEXT,

    FOREIGN KEY (author)
        REFERENCES users(username)
        ON UPDATE CASCADE
) ENGINE=INNODB;




CREATE TABLE comments (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    author          VARCHAR(20) NOT NULL,
    date            TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    contents        MEDIUMTEXT,
    post_id         INT NOT NULL,
    parent_id       INT NOT NULL,
    depth           INT NOT NULL,

    FOREIGN KEY (author)
        REFERENCES users(username)
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
    contents        MEDIUMTEXT,
    FOREIGN KEY (uid)
        REFERENCES users(id)
        ON UPDATE CASCADE

) ENGINE=INNODB;




CREATE TABLE friendship (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid_user1           INT NOT NULL,
    uid_user2           INT NOT NULL,
    signed_user1        BOOLEAN NOT NULL DEFAULT TRUE,
    signed_user2        BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE=INNODB;




CREATE TABLE guardianship (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid_guardian        INT NOT NULL,
    uid_protected       INT NOT NULL,
    signed_protected    BOOLEAN NOT NULL DEFAULT FALSE,
    signed_guardian     BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE=INNODB;




/*
    Catalog
*/
CREATE TABLE product(
    id                  INT PRIMARY KEY,
    title               VARCHAR(30) NOT NULL,
    description         MEDIUMTEXT,
    price_credits       INT UNSIGNED NOT NULL,
    quantity_available  INT UNSIGNED NOT NULL,
    active              BOOLEAN NOT NULL
) ENGINE=INNODB;




CREATE TABLE rating(
    id                  INT PRIMARY KEY,
    uid                 INT NOT NULL,
    product_id          INT NOT NULL,
    value               TINYINT NOT NULL,
    comment             VARCHAR(200),

    FOREIGN KEY (uid)
        REFERENCES users(id)
        ON UPDATE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES product(id)
        ON UPDATE CASCADE
) ENGINE=INNODB;




/*
    Accounting Tables
*/

CREATE TABLE credit(
    uid                 INT PRIMARY KEY,
    credits             INT UNSIGNED NOT NULL,
    last_update         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (uid)
        REFERENCES users(id)
        ON UPDATE CASCADE

) ENGINE=INNODB;




CREATE TABLE transaction_credit (
    id                  INT PRIMARY KEY,
    uid                 INT NOT NULL,
    product_id          INT NOT NULL,
    quantity            INT UNSIGNED NOT NULL,
    price_credits       INT UNSIGNED NOT NULL,
    date                TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    authorized          BOOLEAN NOT NULL DEFAULT FALSE,

    FOREIGN KEY (product_id)
        REFERENCES product(id)

) ENGINE=INNODB;




CREATE TABLE transaction_card (
    id                  INT PRIMARY KEY,
    uid                 INT NOT NULL,
    payment_krw         INT UNSIGNED NOT NULL,
    credit              INT UNSIGNED NOT NULL,
    date                TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    authorized          BOOLEAN NOT NULL DEFAULT FALSE
);




CREATE TABLE transaction_kakaopay (
    id                  INT PRIMARY KEY,
    uid                 INT NOT NULL,
    payments_krw        INT UNSIGNED NOT NULL,
    credit              INT UNSIGNED NOT NULL,
    date                TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    authorized          BOOLEAN NOT NULL DEFAULT FALSE
);





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




CREATE PROCEDURE GetUserByUname (
    IN username_in VARCHAR(30)
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
        username = username_in;
END $$



CREATE PROCEDURE GetIdByUsername (
    IN username VARCHAR(60)
)
BEGIN
    SELECT
        id
    FROM
        users
    WHERE
        users.username = username;
END $$




CREATE PROCEDURE GetExternalUser (
    IN auth_provider ENUM('Google', 'Kakao', 'None'),
    IN id_external VARCHAR(50)
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
        users.auth_provider = auth_provider AND
        users.id_external = id_external;
END $$




/* Todo: Compare Subquery vs Inner Join */
CREATE PROCEDURE GetCamOwner (
    IN cam_id INT
)
BEGIN
    SELECT
        id, username
    FROM
        users
    WHERE
        users.id = (SELECT
                        owner_uid
                    FROM
                        cam_ownership
                    WHERE
                        cam_ownership.cam_id = cam_id
                    );
END $$




/* Todo: Compare Subquery vs Inner Join */
/*
CREATE PROCEDURE AuthStream (
    IN stream_key VARCHAR(32)
)
BEGIN
    SELECT
        id
    FROM
        users
    WHERE
        users.stream_key = stream_key;
END $$
*/



CREATE PROCEDURE GetGuardians (
    IN username VARCHAR(60)
)
BEGIN
    SELECT
        id, username
    FROM
        users
    WHERE
        users.id = (
            /* Get guardians' UIDs from their usernames */
            SELECT
                uid_guardian

            FROM
                guardianship

            WHERE
                uid_protected =(
                                    SELECT
                                        id
                                    FROM
                                        users
                                    WHERE
                                        users.username = username
                                )
                AND guardianship.signed_protected IS TRUE
                AND guardianship.signed_guardian IS TRUE
        );
END $$





DELIMITER ;
