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

    google2fa_secret   VARCHAR(50) DEFAULT NULL,

    image_url       VARCHAR(200) DEFAULT NULL,
    image           LONGBLOB DEFAULT NULL,

    email           VARCHAR(50) UNIQUE,
    cell            VARCHAR(20) UNIQUE DEFAULT NULL,
    stream_key      VARCHAR(32) NOT NULL, /* @Todo: Make Bcrypt Hash */
    webToken        VARCHAR(200),
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
    proxy_enable        BOOL DEFAULT NULL,
    password_hint       MEDIUMTEXT DEFAULT NULL,
    hint_answer         VARCHAR(50) DEFAULT NULL,
    email_verified_at   DATETIME DEFAULT NULL,

    CONSTRAINT no_duplicate_oauth UNIQUE (uid_oauth, auth_provider),
    CONSTRAINT UNIQUE (id, status), /* @Todo  -  Why does streams foreign key does not work without this??? */

    INDEX(status, response)

) ENGINE=INNODB;


CREATE TABLE deleted_users (
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    request_timestamp   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;




CREATE TABLE camera_specs (
    model_no            VARCHAR(20) UNIQUE NOT NULL,
    revision            INT NOT NULL,
    product_name        VARCHAR(60) UNIQUE NOT NULL,
    description         MEDIUMTEXT NOT NULL,
    img_url             VARCHAR(200) DEFAULT NULL,

    CONSTRAINT PRIMARY KEY (model_no, revision)

) ENGINE=INNODB;




CREATE TABLE camera_registered (
    cam_id              INT AUTO_INCREMENT PRIMARY KEY,
    owner_uid           INT NOT NULL,
    model_no            VARCHAR(20) NOT NULL,
    revision            INT NOT NULL,
    date_registered     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (owner_uid) REFERENCES users(id)

    /*CONSTRAINT FOREIGN KEY (model_no, revision) REFERENCES camera_specs(model_no, revision)*/
) ENGINE=INNODB;



CREATE TABLE repair_history (
    reference_no    INT AUTO_INCREMENT  PRIMARY KEY,
    cam_id          INT NOT NULL,
    description     MEDIUMTEXT,
    date            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (cam_id) REFERENCES camera_registered(cam_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB;



CREATE TABLE streams (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid                 INT NOT NULL,
    date_report         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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
    FOREIGN KEY (uid) REFERENCES users(id) ON UPDATE CASCADE
) ENGINE=INNODB;




CREATE TABLE stream_webtokens (
    id                  INT PRIMARY KEY AUTO_INCREMENT,
    stream_id           INT NOT NULL,
    uid                 INT NOT NULL,
    token               VARCHAR(200) NOT NULL,
    last_update         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY (stream_id, uid),
    FOREIGN KEY (stream_id) REFERENCES streams(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB;




CREATE TABLE posts (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    forum           ENUM (
                        'general',
                        'tech'
                    ),
    title           VARCHAR(100) NOT NULL,
    author          VARCHAR(20) NOT NULL,
    date            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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




CREATE TABLE post_likes (
    post_id         INT NOT NULL,
    uid             INT NOT NULL,

    PRIMARY KEY (post_id, uid),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=INNODB;




CREATE TABLE support_request (
    id       INT auto_increment PRIMARY KEY,
    uid      INT DEFAULT NULL,
    contact  VARCHAR(60) NOT NULL,
    type     ENUM ('REPAIR', 'TECH_SUPPORT', 'REFUND', 'LEGAL'),
    status   ENUM('PENDING', 'RESPONDED', 'RESOLVED') DEFAULT 'PENDING',
    contents MEDIUMTEXT
) ENGINE=INNODB;




CREATE TABLE guardianship (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    uid_guardian        INT NOT NULL,
    uid_protected       INT NOT NULL,
    signed_protected    ENUM('WAITING', 'ACCEPTED', 'DENIED') NOT NULL DEFAULT 'WAITING',
    signed_guardian     ENUM('WAITING', 'ACCEPTED', 'DENIED') NOT NULL DEFAULT 'WAITING',

    CONSTRAINT no_duplicate UNIQUE (uid_guardian, uid_protected),
    INDEX (uid_guardian),
    INDEX (uid_protected)
) ENGINE=INNODB;




/*
    Catalog
*/
CREATE TABLE products(
    id                  INT PRIMARY KEY,
    title               VARCHAR(30) UNIQUE NOT NULL,
    description         MEDIUMTEXT,
    price_credits       INT UNSIGNED NOT NULL,
    active              BOOLEAN NOT NULL
) ENGINE=INNODB;


CREATE TABLE warehouses(
    id              INT PRIMARY KEY,
    distributor     VARCHAR(200),
    location        MEDIUMTEXT NOT NULL,

    CONSTRAINT unique_location UNIQUE (distributor, location)
) ENGINE=INNODB;


CREATE TABLE product_stocks(
    id                  INT PRIMARY KEY,
    warehouse_id        INT NOT NULL,
    product_id          INT NOT NULL,
    quantity_available  INT UNSIGNED,
    last_purchase       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT UNIQUE (warehouse_id, product_id),
    CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(id) ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON UPDATE CASCADE
) ENGINE=INNODB;







CREATE TABLE ratings(
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

CREATE TABLE credits(
    uid                 INT PRIMARY KEY,
    credits             INT UNSIGNED NOT NULL,
    last_update         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (uid) REFERENCES users(id) ON UPDATE CASCADE
) ENGINE=INNODB;




CREATE TABLE product_purchases (
    id                  INT PRIMARY KEY,
    uid                 INT NOT NULL,
    product_id          INT NOT NULL,
    quantity            INT UNSIGNED NOT NULL,
    credits_expended    INT UNSIGNED NOT NULL,
    date                TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    authorized          BOOLEAN NOT NULL DEFAULT false,

     FOREIGN KEY (product_id) REFERENCES products(id),
     FOREIGN KEY (uid) REFERENCES users(id)
) ENGINE=INNODB;




CREATE TABLE credit_purchases (
    id              INT PRIMARY KEY,
    uid             INT NOT NULL,
    payment_usd     FLOAT UNSIGNED NOT NULL,
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


COMMIT;


/* -------------------------------------------------------------------------- */
/*                              Stored Procedures                             */
/* -------------------------------------------------------------------------- */


DELIMITER $$


/* ----------------------------- User Management ---------------------------- */

CREATE PROCEDURE GetUserByName (
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




CREATE PROCEDURE GetUserByOAuthID (
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




/* ------------------------- E-Commerce Transactions ------------------------ */

CREATE PROCEDURE PurchaseCredits(
    IN qty_purchased INT,
    IN uid INT,
    IN usd_paid FLOAT,
    OUT result INT
)
BEGIN
    DECLARE current_credits INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET result = -1;
    END;


    START TRANSACTION;

        SELECT credits
        INTO current_credits
        FROM credits
        WHERE credits.uid = uid
        FOR UPDATE;

        UPDATE credits
        SET credits.credits = current_credits + qty_purchased
        WHERE credits.uid = uid;

        INSERT INTO credit_purchases(uid, payment_usd, credit, authorized)
        VALUES(uid, usd_paid, qty_purchased, 1);

        COMMIT;
        SET result = 0;
END$$




CREATE PROCEDURE PurcahseProduct(
    IN qty_purchased INT,
    IN uid INT,
    IN credits_paid FLOAT,
    IN product_id INT,
    OUT result INT
)
BEGIN

    DECLARE unit_price_credits FLOAT DEFAULT 0.0;
    DECLARE current_credits INT DEFAULT 0;
    DECLARE current_stock INT DEFAULT 0;


    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET result = -1;
    END;

    START TRANSACTION;
        SELECT credits
        INTO current_credits
        FROM credits
        WHERE credits.uid = uid
        FOR UPDATE;

        SELECT quantity_available
        INTO current_stock
        FROM product_stocks
        WHERE product_stocks.product_id = product_id
        FOR UPDATE;

        IF (current_stock < qty_purchased) THEN
            /* Insufficient stock level */
            ROLLBACK;
            SET result= -1 ;
        ELSEIF (current_credits < (qty_purchased * unit_price_credits)) THEN
            /* Not enough credits */
            ROLLBACK;
            SET result= -1 ;
        ELSE
            /* Proceed payment */
            UPDATE product_stocks
            SET quantity_available = (SELECT quantity_available
                                    FROM product_stocks
                                    WHERE product_stocks.product_id = product_id);

            INSERT INTO product_purchases (uid, product_id, quantity, credits_expended, authorized)
            VALUES (uid, product_id, qty_purchased, unit_price_usd * qty_purchased, 1);

            UPDATE credits
            SET credits.credits = current_credits + (qty_purchased * unit_price_credits)
            WHERE credits.uid = uid;
            COMMIT;
            SET result = 0;
        END IF;

END$$




/* ----------------------- Camera Ownership Management ---------------------- */

CREATE PROCEDURE GetCamOwner (
    IN cam_id INT
)
BEGIN
    SELECT id,
           username
    FROM   users
    WHERE  users.id = ( SELECT owner_uid
                        FROM   camera_registered
                        WHERE  camera_registered.cam_id = cam_id);

    COMMIT;
END $$




CREATE PROCEDURE GetCameraInfo (
    IN username VARCHAR(60)
)
BEGIN
    SELECT cam_id
    FROM   camera_registered
    WHERE  users.id = ( SELECT id
                        FROM   users
                        WHERE  users.username = username);

    COMMIT;
END $$




/* --------------------- Guardianship Management Queries -------------------- */

CREATE PROCEDURE GetGuardians (
    IN username VARCHAR(60)
)
BEGIN

SELECT users.id,
       users.username,
       users.image_url,
       users.cell,
       users.email
FROM   users
WHERE  users.id IN (
                   /* Get guardians' UIDs from their usernames */
                    SELECT uid_guardian
                    FROM   guardianship
                    WHERE  uid_protected = (SELECT id
                                            FROM   users
                                            WHERE  users.username = username)
                           AND guardianship.signed_protected = 'ACCEPTED'
                           AND guardianship.signed_guardian = 'ACCEPTED');
COMMIT;
END $$




CREATE PROCEDURE GetProtecteds (
    IN username VARCHAR(60)
)
BEGIN

SELECT users.id,
       users.username,
       users.image_url,
       users.cell,
       users.email,
       users.status
FROM   users
WHERE  users.id IN (
                   /* Get guardians' UIDs from their usernames */
                   SELECT uid_protected
                    FROM   guardianship
                    WHERE  uid_guardian = (SELECT id
                                           FROM   users
                                           WHERE  users.username = username)
                           AND guardianship.signed_protected = 'ACCEPTED'
                           AND guardianship.signed_guardian = 'ACCEPTED');

COMMIT;
END $$




CREATE PROCEDURE GetPendingRequests(
    IN uid INT
)
BEGIN

    (SELECT guardianship.*, users.username
    FROM   guardianship
    INNER JOIN users
    ON guardianship.uid_guardian=users.id
    WHERE   ( guardianship.uid_protected = uid
                AND guardianship.signed_protected = 'WAITING' ))

    UNION

    (SELECT guardianship.*, users.username
    FROM   guardianship
    INNER JOIN users
    ON guardianship.uid_protected = users.id
    WHERE   ( guardianship.uid_guardian = uid
                AND guardianship.signed_guardian = 'WAITING' ));

    COMMIT;


END $$




CREATE PROCEDURE RespondPeerRequest(
    IN reqID INT,
    IN uid INT,
    IN response ENUM('WAITING', 'ACCEPTED', 'DENIED')
)
BEGIN
    DECLARE id_protected INT;
    DECLARE id_guardian INT;

    START TRANSACTION;
        SELECT uid_protected, uid_guardian
        INTO id_protected, id_guardian
        FROM guardianship
        WHERE guardianship.id = reqID;

        IF (uid = id_protected) THEN
            UPDATE guardianship
            SET signed_protected = response
            WHERE guardianship.id = reqID;

        ELSEIF (uid = id_guardian) THEN
            UPDATE guardianship
            SET signed_guardian = response
            WHERE guardianship.id = reqID;
        END IF;

    COMMIT;

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
END $$




/* Todo*/
CREATE PROCEDURE GetEndangeredPeers (
    IN username VARCHAR(60)
)
BEGIN

    SELECT  users.id, users.username
    FROM    users
    WHERE   users.id IN (
                            SELECT      parent.uid_protected
                            FROM        guardianship AS parent
                            INNER JOIN  guardianship AS child
                            ON          child.uid_guardian = parent.uid_guardian
                            WHERE       child.uid_protected = username
                        );
END $$




/* ----------------------- Emergency Streaming Queries ---------------------- */

CREATE PROCEDURE GetStreamKey(
    IN username VARCHAR(30)
)
BEGIN
    SELECT  stream_key
    FROM    users
    WHERE   users.username=username;
END $$




CREATE PROCEDURE RegisterWebTokens(
    IN stream_id_i  INT,
    IN username     VARCHAR(60),
    IN jwt          VARCHAR(200)
)
BEGIN
    START TRANSACTION;
        INSERT INTO stream_webtokens(stream_id, uid, token)
        VALUES (
            stream_id_i,
            (
                SELECT id
                FROM users
                WHERE users.username=username
            ),
            jwt
        );
    COMMIT;
END $$




CREATE PROCEDURE GetStreamJwt(
    IN uid_guardian INT,
    IN username_protected VARCHAR(60)
)
BEGIN
    START TRANSACTION;
        SELECT token
        FROM   stream_webtokens
        WHERE  uid = uid_guardian
            AND stream_id = (SELECT id
                            FROM   streams
                            WHERE  uid = ( SELECT id
                                            FROM   users
                                            WHERE  username = uname_protected));
    COMMIT;
END $$




CREATE PROCEDURE GetMyJwt(
    IN uid VARCHAR(60)
)
BEGIN
    SELECT  webToken
    FROM    users
    WHERE   users.uid = uid;
END$$




CREATE PROCEDURE ReportEmergency(
    IN username VARCHAR(60)
)
BEGIN

    /* Transaction Exception Handler */
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;


    START TRANSACTION;
        CALL GetIdByUsername(username, @uid);
        SELECT stream_key
        INTO   @stream_key
        FROM   users
        WHERE  users.uid = @uid;

        SELECT Group_concat(uid_guardian)
        INTO   @guardians
        FROM   guardianship
        WHERE  uid_protected = @uid;

        UPDATE users
        SET    status = 'DANGER_URGENT'
        WHERE  users.uid = @uid;

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
    COMMIT;

END $$




CREATE PROCEDURE StartEmergencyProtocol(
    IN username VARCHAR(60)
)
BEGIN
    /* Transaction Exception Handler */
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;
        CALL GetIdByUsername(username, @uid);

        UPDATE streams
        SET    status = 'DANGER_URGENT',
            response = 'RESPONSE_REQUIRED'
        WHERE  streams.uid = @uid;
    COMMIT;
END $$




CREATE PROCEDURE StopEmergencyProtocol(
    IN username VARCHAR(60)
)
BEGIN
    /* Transaction Exception Handler */
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;
        CALL GetIdByUsername(username, @uid);

        UPDATE streams
        SET    status = 'FINE',
            response = 'RESOLVED'
        WHERE  streams.uid = @uid;
    COMMIT;
END $$




CREATE PROCEDURE StartStream (
    IN username VARCHAR(60)
)
BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;
        CALL GetIdByUsername(username, @uid);

        INSERT INTO streams(uid, responders, stream_key)
        VALUES (
            (
                SELECT id
                FROM   users
                WHERE  users.username = username
            ),
            (
                SELECT Group_concat(uid_guardian)
                FROM   guardianship
                WHERE  uid_protected = @uid
            ),
            (
                SELECT stream_key
                FROM   users
                WHERE  users.username = username
            )
        );
    COMMIT;
END $$




CREATE PROCEDURE CloseStream(
    IN username VARCHAR(60)
)
BEGIN

    /* Transaction Exception Handler */
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;
        CALL GetIdByUsername(username, @uid);
        DELETE FROM streams WHERE streams.uid = @uid;
    COMMIT;
END $$




/* ------------------------------- Forum CRUD ------------------------------- */

CREATE PROCEDURE SearchPosts (
    IN keyword VARCHAR(100)
)
BEGIN
    /* @Todo */
END $$




CREATE PROCEDURE GetTrendingPosts(
)
BEGIN
    /* Get most viewed posts of latest 7 days */
    SELECT id,
           title,
           forum,
           DATE(date) AS date
    FROM   posts
    WHERE  date BETWEEN ( Now() - INTERVAL 7 day ) AND Now()
    ORDER  BY view_count DESC
    LIMIT  10;

    COMMIT;
END$$




CREATE PROCEDURE GetTopPosts(
)
BEGIN

    /* Get most viewed posts of all time */
    SELECT id,
           title,
           forum,
           DATE(date) AS date
    FROM   posts
    ORDER  BY view_count DESC
    LIMIT  10;

    COMMIT;
END$$




CREATE PROCEDURE GetPostLikeCount(
    IN post_id INT
)
BEGIN
    SELECT COUNT(*)
    FROM post_likes
    WHERE post_likes.post_id = post_id;

    COMMIT;
END$$



DELIMITER ;

/* -------------------------------------------------------------------------- */
/*                             /Stored Procedures                             */
/* -------------------------------------------------------------------------- */

COMMIT;
