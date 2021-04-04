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
                    ) DEFAULT 'FINE' NOT NULL,
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

    CONSTRAINT no_duplicate_oauth UNIQUE (uid_oauth, auth_provider),
    CONSTRAINT UNIQUE (id, status), /* @Todo  -  Why does streams foreign key does not work without this??? */

    INDEX(status, response)

) ENGINE=INNODB;




CREATE TABLE camera_specs (
    model_no            VARCHAR(20) NOT NULL,
    revision            INT NOT NULL,
    product_name        VARCHAR(60) NOT NULL,
    description         MEDIUMTEXT NOT NULL,
    img_url             VARCHAR(200) DEFAULT NULL,

    CONSTRAINT PRIMARY KEY (model_no, revision)

) ENGINE=INNODB;




CREATE TABLE camera_registered (
    cam_id              INT AUTO_INCREMENT PRIMARY KEY,
    owner_uid           INT NOT NULL,
    model_no            VARCHAR(20) NOT NULL,
    revision            INT NOT NULL,
    date_registered     TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    /*CONSTRAINT FOREIGN KEY (model_no, revision) REFERENCES camera_specs(model_no, revision)*/
) ENGINE=INNODB;



CREATE TABLE AS_records (
    reference_no    INT AUTO_INCREMENT  PRIMARY KEY,
    cam_id          INT NOT NULL,
    description     MEDIUMTEXT,

    FOREIGN KEY (cam_id) REFERENCES camera_registered(cam_id) ON UPDATE CASCADE
) ENGINE=INNODB;



CREATE TABLE streams (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid                 INT NOT NULL,
    date_report         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status              ENUM(
                            'DANGER_URGENT',
                            'FINE'
                        ) DEFAULT 'FINE' NOT NULL,
    response            ENUM(
                            'RESPONSE_REQUIRED',
                            'FIRST_RESPONDERS_DISPATCHED',
                            'FIRST_RESPONDERS_ARRIVED',
                            'RESOLVING',
                            'RESOLVED'
                        ) DEFAULT NULL,
    responders          MEDIUMTEXT,
    stream_key          VARCHAR(32) NOT NULL,   /* HASHED!!! */
    description         MEDIUMTEXT DEFAULT NULL,

    CONSTRAINT one_stream_per_user UNIQUE (uid),
    FOREIGN KEY (uid, status) REFERENCES users(id, status) ON UPDATE CASCADE
) ENGINE=INNODB;




CREATE TABLE stream_webtokens (
    stream_id           INT NOT NULL,
    uid                 INT NOT NULL,
    token               VARCHAR(200) NOT NULL,

    UNIQUE KEY (stream_id, uid)
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

    FOREIGN KEY (author) REFERENCES users(username) ON UPDATE CASCADE
) ENGINE=INNODB;




CREATE TABLE comments (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    author          VARCHAR(20) NOT NULL,
    date            TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    contents        MEDIUMTEXT,
    post_id         INT NOT NULL,
    parent_id       INT DEFAULT NULL,
    depth           INT NOT NULL DEFAULT 0,

    FOREIGN KEY (author) REFERENCES users(username) ON UPDATE CASCADE
) ENGINE=INNODB;




CREATE TABLE support_request (
    id       INT auto_increment PRIMARY KEY,
    uid      INT NOT NULL,
    type     ENUM ('REPAIR', 'TECH_SUPPORT', 'REFUND', 'LEGAL'),
    status   ENUM('PENDING', 'RESPONDED', 'RESOLVED'),
    contents MEDIUMTEXT,

    FOREIGN KEY (uid) REFERENCES users(id) ON UPDATE CASCADE
) ENGINE=INNODB;



/*
CREATE TABLE friendship (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid_user1           INT NOT NULL,
    uid_user2           INT NOT NULL,
    signed_user1        BOOLEAN NOT NULL DEFAULT TRUE,
    signed_user2        BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE=INNODB;
*/



CREATE TABLE guardianship (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid_guardian        INT NOT NULL,
    uid_protected       INT NOT NULL,
    signed_protected    BOOLEAN NOT NULL DEFAULT FALSE,
    signed_guardian     BOOLEAN NOT NULL DEFAULT FALSE,

    CONSTRAINT no_duplicate UNIQUE (uid_guardian, uid_protected)
) ENGINE=INNODB;




/*
    Catalog
*/
CREATE TABLE products(
    id                  INT PRIMARY KEY,
    title               VARCHAR(30) NOT NULL,
    description         MEDIUMTEXT,
    price_credits       INT UNSIGNED NOT NULL,
    quantity_available  INT UNSIGNED,
    active              BOOLEAN NOT NULL
) ENGINE=INNODB;




CREATE TABLE rating(
    id                  INT PRIMARY KEY,
    uid                 INT NOT NULL,
    product_id          INT NOT NULL,
    value               TINYINT NOT NULL,
    comment             VARCHAR(200),

    FOREIGN KEY (uid) REFERENCES users(id) ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON UPDATE CASCADE
) ENGINE=INNODB;




/*
    Accounting Tables
*/

CREATE TABLE credit(
    uid                 INT PRIMARY KEY,
    credits             INT UNSIGNED NOT NULL,
    last_update         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (uid) REFERENCES users(id) ON UPDATE CASCADE
) ENGINE=INNODB;




CREATE TABLE transactions_products (
    id              INT PRIMARY KEY,
    uid             INT NOT NULL,
    product_id      INT NOT NULL,
    quantity        INT UNSIGNED NOT NULL,
    price_credits   INT UNSIGNED NOT NULL,
    date            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    authorized      BOOLEAN NOT NULL DEFAULT false,

     FOREIGN KEY (product_id) REFERENCES products(id),
     FOREIGN KEY (uid) REFERENCES users(id)

) ENGINE=INNODB;




CREATE TABLE transactions_credits (
    id              INT PRIMARY KEY,
    uid             INT NOT NULL,
    payment_krw     INT UNSIGNED NOT NULL,
    credit          INT UNSIGNED NOT NULL,
    date            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    authorized      BOOLEAN NOT NULL DEFAULT FALSE
);




CREATE TABLE donations_kakaopay (
    id                  INT PRIMARY KEY,
    uid                 INT NOT NULL,
    payments_krw        INT UNSIGNED NOT NULL,
    credit              INT UNSIGNED NOT NULL,
    date                TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    authorized          BOOLEAN NOT NULL DEFAULT FALSE
);






/* -------------------------------------------------------------------------- */
/*                              Stored Procedures                             */
/* -------------------------------------------------------------------------- */


DELIMITER $$

CREATE PROCEDURE GetUserByEmail (
    IN user_email VARCHAR(50)
)
BEGIN
    SELECT firstname,
           lastname,
           username,
           email,
           cell,
           auth_provider,
           stream_id,
           status,
           response
    FROM   users
    WHERE  email = user_email;
END $$




CREATE PROCEDURE GetUserByUname (
    IN username_in VARCHAR(30)
)
BEGIN
    SELECT firstname,
           lastname,
           username,
           email,
           cell,
           auth_provider,
           stream_id,
           status,
           response
    FROM   users
    WHERE  username = username_in;
END $$



CREATE PROCEDURE GetStreamKey(
    IN username VARCHAR(30)
)
BEGIN
    SELECT  stream_key
    FROM    users
    WHERE   users.username=username;
END $$



CREATE PROCEDURE GetIdByUsername (
    IN username VARCHAR(60),
    OUT uid_out INT
)
BEGIN
    SELECT id
    INTO   uid_out
    FROM   users
    WHERE  users.username = username;
END $$



CREATE PROCEDURE GetExternalUser (
    IN auth_provider ENUM('Google', 'Kakao', 'None'),
    IN id_external VARCHAR(50)
)
BEGIN
    SELECT  firstname,
            lastname,
            username,
            email,
            cell,
            auth_provider,
            stream_id,
            status,
            response
    FROM    users
    WHERE   users.auth_provider = auth_provider
            AND users.id_external = id_external;
END $$




CREATE PROCEDURE GetCamOwner (
    IN cam_id INT
)
BEGIN
    SELECT id,
           username
    FROM   users
    WHERE  users.id = ( SELECT owner_uid
                        FROM   cameras
                        WHERE  cameras.cam_id = cam_id);
END $$




CREATE PROCEDURE GetCamera (
    IN username VARCHAR(60)
)
BEGIN
    SELECT cam_id
    FROM   camera_registered
    WHERE  users.id = ( SELECT id
                        FROM   users
                        WHERE  users.username = username);
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

SELECT users.id,
       users.username
FROM   users
WHERE  users.id IN (
                   /* Get guardians' UIDs from their usernames */
                    SELECT uid_guardian
                    FROM   guardianship
                    WHERE  uid_protected = (SELECT id
                                            FROM   users
                                            WHERE  users.username = username)
                           AND guardianship.signed_protected IS TRUE
                           AND guardianship.signed_guardian IS TRUE);
END $$




CREATE PROCEDURE GetProtecteds (
    IN username VARCHAR(60)
)
BEGIN

SELECT users.id,
       users.username,
       users.status
FROM   users
WHERE  users.id IN (
                   /* Get guardians' UIDs from their usernames */
                   SELECT uid_protected
                    FROM   guardianship
                    WHERE  uid_guardian = (SELECT id
                                           FROM   users
                                           WHERE  users.username = username)
                           AND guardianship.signed_protected IS TRUE
                           AND guardianship.signed_guardian IS TRUE);
END $$




CREATE PROCEDURE ReportEmergency(
    IN username VARCHAR(60)
)
BEGIN
    UPDATE users
    SET    status = 'DANGER_URGENT'
    WHERE  users.username = username;

    CALL GetIdByUsername(username, @uid);

    SELECT stream_key
    INTO   @stream_key
    FROM   users
    WHERE  users.username = username;

    SELECT Group_concat(uid_guardian)
    INTO   @guardians
    FROM   guardianship
    WHERE  uid_protected = @uid;

    INSERT INTO streams
                (
                    uid,
                    status,
                    response,
                    stream_key,
                    responders
                )
    VALUES      (
                    @uid,
                    'DANGER_URGENT',
                    'RESPONSE_REQUIRED',
                    @stream_key,
                    @guardians
                );

END $$




CREATE PROCEDURE GetEndangeredProtecteds (
    IN username_i VARCHAR(60)
)
BEGIN
    SELECT  users.id,
            users.username
    FROM    users
            INNER JOIN  guardianship
                    ON  guardianship.uid_protected = users.id
    WHERE   guardianship.uid_guardian IN (  SELECT users.id
                                            FROM   users
                                            WHERE  username = username_i)
            AND users.status = "DANGER_URGENT";
/*
    SELECT  users.id,
            users.username
    FROM    users
    WHERE   users.id IN (SELECT guardianship.uid_protected
                        FROM    guardianship
                        WHERE   guardianship.uid_guardian = (SELECT users.id
                                                            FROM   users
                                                            WHERE
                                users.username = username
                                                        ))
            AND users.status = "danger_urgent";
*/
END $$





/* Todo*/
CREATE PROCEDURE GetEndangeredPeers (
    IN username VARCHAR(60)
)
BEGIN
    /*
    SELECT  users.id, users.username
    FROM    users
    WHERE   users.id IN (
                            SELECT  uid_protected
                            FROM    guardianship
                            WHERE   uid_guardian IN (
                                                        SELECT  uid_guardian
                                                        FROM    guardianship
                                                        WHERE   uid_protected = 2
                                                    )
                            AND     uid_protected !=
                        );


    SELECT  users.id, users.username
    FROM    users
    WHERE   users.id IN (
                            SELECT      parent.uid_protected
                            FROM        guardianship AS parent
                            INNER JOIN  guardianship AS child
                            ON          child.uid_guardian = parent.uid_guardian
                            WHERE       child.uid_protected = 3
                        );
     */

    SELECT  users.id, users.username
    FROM    users
    WHERE   users.id IN (
                            SELECT      parent.uid_protected
                            FROM        guardianship AS parent
                            INNER JOIN  guardianship AS child
                            ON          child.uid_guardian = parent.uid_guardian
                            WHERE       child.uid_protected = 3
                        );
END $$




CREATE PROCEDURE StartEmergencyProtocol(
    IN username VARCHAR(60)
)
BEGIN
    CALL getidbyusername(username, @uid);

    UPDATE streams
    SET    status = 'DANGER_URGENT',
           response = 'RESPONSE_REQUIRED'
    WHERE  streams.uid = @uid;
END $$




CREATE PROCEDURE StartStream (
    IN username VARCHAR(60)
)
BEGIN

    CALL GetIdByUsername(username, @uid);

    INSERT INTO streams(uid, responders, stream_key)
    VALUES (
        (
            SELECT id
            FROM   users
            WHERE  users.username = "user2"
        ),
        (
            SELECT Group_concat(uid_guardian)
            FROM   guardianship
            WHERE  uid_protected = 3
        ),
        (
            SELECT stream_key
            FROM   users
            WHERE  users.username = "user2"
        )
    );

    SELECT  id
    FROM    streams
    WHERE   streams.uid=@uid;
END $$




CREATE PROCEDURE CloseStream(
    IN username VARCHAR(60)
)
BEGIN
    CALL GetIdByUsername(username, @uid);
    DELETE FROM streams WHERE streams.uid = @uid;
END $$




explain INSERT INTO streams(uid, responders, stream_key)
VALUES (
    (
        SELECT id
        FROM   users
        WHERE  users.username = "user2"
    ),
    (
        SELECT Group_concat(uid_guardian)
        FROM   guardianship
        WHERE  uid_protected = 11
    ),
    (
        SELECT stream_key
        FROM   users
        WHERE  users.username = "user2"
    )
);




/* Todo */
CREATE PROCEDURE SearchPosts (
    IN keyword VARCHAR(100)
)
BEGIN

END $$




CREATE PROCEDURE RegisterWebTokens(
    IN stream_id_i  INT,
    IN username     VARCHAR(60),
    IN jwt          VARCHAR(200)
)
BEGIN

    SELECT id
    INTO @uid
    FROM users
    WHERE users.username=username;


    INSERT INTO stream_webtokens(stream_id, uid, token)
    VALUES (
        stream_id_i,
        @uid,
        jwt
    );
END $$




DELIMITER ;
