CREATE TABLE users
(
	id SERIAL,
	pass VARCHAR(50),
	mail VARCHAR(320) UNIQUE,
	name VARCHAR(50),
	surname VARCHAR(50),
	date_birth DATE,
	created DATE DEFAULT NOW(),

	PRIMARY KEY (id)
);

CREATE TABLE places
(
	id SERIAL,
	name VARCHAR(50),
	photo_name VARCHAR(50),
	latitude NUMERIC(8, 6),
	longitude NUMERIC(9, 6),

	PRIMARY KEY (id)
);

CREATE TABLE visited
(
	id SERIAL,
	user_id INTEGER,
	place_id INTEGER,
	created DATE DEFAULT NOW(),

	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (place_id) REFERENCES places(id),
	PRIMARY KEY (id)
);

CREATE TABLE marks
(
	id SERIAL,
	user_id INTEGER,
	place_id INTEGER,
	mark NUMERIC(1) CHECK (mark >= 0 AND mark <= 5),

	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (place_id) REFERENCES places(id),
	PRIMARY KEY (id)
);

CREATE TABLE place_comments
(
	id SERIAL,
	user_id INTEGER,
	place_id INTEGER,
	content TEXT,

	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (place_id) REFERENCES places(id),
	PRIMARY KEY (id)
);

CREATE TABLE comment_likes
(
	id SERIAL,
	user_id INTEGER,
	place_comment_id INTEGER,

	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (place_comment_id) REFERENCES place_comments(id),
	PRIMARY KEY (id)
);
