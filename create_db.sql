
DROP TABLE image;

CREATE TABLE image (
    image_id char(32) PRIMARY KEY,
    app_id varchar(32) NOT NULL,
    name varchar(128),
    md5 varchar(128) NOT NULL,
    path_file varchar(128) NOT NULL,
    width TINYINT NOT NULL,
    height TINYINT NOT NULL,
    size int NOT NULL,
    type varchar(16) NOT NULL,
    created DATETIME NOT NULL,
    updated DATETIME,
    deleted DATETIME
);
