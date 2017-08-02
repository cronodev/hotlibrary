CREATE DATABASE "HOTLIBRARY";

CREATE TABLE "User"(
  "id"        SERIAL        NOT NULL,
  "name"      VARCHAR(100)  NOT NULL,
  "email"     VARCHAR(100)  NOT NULL  UNIQUE,
  "password"  VARCHAR(128)  NOT NULL,
  "isActive"  BOOLEAN       NOT NULL  DEFAULT TRUE,
  "isAdmin"   BOOLEAN       NOT NULL  DEFAULT FALSE,
  PRIMARY KEY ("id")
);
