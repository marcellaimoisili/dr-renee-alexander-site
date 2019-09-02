-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables
CREATE TABLE users (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	username TEXT NOT NULL UNIQUE,
	password TEXT NOT NULL
);

CREATE TABLE sessions (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	user_id INTEGER NOT NULL,
	session TEXT NOT NULL UNIQUE
);

-- Create Table for Images for About Page
CREATE TABLE about_images(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	img_ext TEXT NOT NULL,
    year INTEGER NOT NULL,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
	caption TEXT NOT NULL
);

-- Project Page Tables

CREATE TABLE projects_images (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	file_name TEXT NOT NULL,
	file_ext TEXT NOT NULL,
	description TEXT NOT NULL,
	event_type TEXT NOT NULL,
	event_name TEXT NOT NULL
);


CREATE TABLE tags(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	tag_name TEXT NOT NULL
);

CREATE TABLE project_tag(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    projects_image_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL
);



-- TODO: initial seed data
INSERT INTO `users`(id, username, password) VALUES (1, 'renee', '$2y$10$XvgrWCNI3Y9FNuslB2Hc9eE4Vw0VTor2VV0T1wOsp/2FPMYq0Hgju'); -- password: alexander
-- TODO: FOR HASHED PASSWORDS, LEAVE A COMMENT WITH THE PLAIN TEXT PASSWORD!

--Inserting data to projects_images
-- Photos provided by Dr. Renee

INSERT INTO 'projects_images'(id, file_name, file_ext, description, event_type, event_name) VALUES (1, 'fall2014', 'jpg', '(Fall, 2014) Sigma Alpha Mu (SAMI) & Alpha Lambda Mu (ALM) – “Breaking Bread” at 626 with Jewish and Muslim fraternity brothers.  This event built on the energy and relationship-building of Cornell Hillel and MECA (Muslim Educational and Cultural Assn) BB several months earlier (Spring 2014).', 'Past', 'Breaking Bread with SAMI and ALM');

INSERT INTO 'projects_images'(id, file_name, file_ext, description, event_type, event_name) VALUES (2, 'spring2015', 'JPG', '(Spring 2015) Sigma Pi & Alpha Phi Alpha – after a racially charged incident between Sigma Pi and students of color (including APA leadership), and Sigma Pi being placed on probation, these groups agreed to sit at the “table of brotherhood.” Three “Breaking Bread” gatherings led to authentic relationships and positive interactions between these fraternal organizations', 'Past', 'Breaking Bread with Sigma Pi and Alpha Phi Alpha');

INSERT INTO 'projects_images'(id, file_name, file_ext, description, event_type, event_name) VALUES (3, 'spring2016', 'jpg', '(Spring 2016) Cornell Daily SUN & Black Students United (BSU) – “Breaking Bread” at Balch Hall with BSU’s e-board and SUN’s editorial staff, to address concerns about how Students of Color are portrayed in news coverage and photographs.  This conversation stimulated ongoing relationships and positive dialogue between organizations.', 'Past', 'Breaking Bread with SUN and BSU');


-- Tag data
INSERT INTO `tags`(id, tag_name) VALUES (1, 'Breaking Bread');
INSERT INTO `tags`(id, tag_name) VALUES (2, 'Cornell University');
INSERT INTO `tags`(id, tag_name) VALUES (3, 'Facilitation');
INSERT INTO `tags`(id, tag_name) VALUES (4, 'Communication');

INSERT INTO `project_tag`(id, projects_image_id, tag_id) VALUES (1, 1, 1);
INSERT INTO `project_tag`(id, projects_image_id, tag_id) VALUES (2, 1, 2);
INSERT INTO `project_tag`(id, projects_image_id, tag_id) VALUES (3, 2, 1);
INSERT INTO `project_tag`(id, projects_image_id, tag_id) VALUES (4, 2, 2);
INSERT INTO `project_tag`(id, projects_image_id, tag_id) VALUES (5, 3, 1);
INSERT INTO `project_tag`(id, projects_image_id, tag_id) VALUES (6, 3, 2);
INSERT INTO `project_tag`(id, projects_image_id, tag_id) VALUES (7, 2, 3);
INSERT INTO `project_tag`(id, projects_image_id, tag_id) VALUES (8, 3, 4);

-- Inserting data to about_images
-- Photos provided by Dr. Renee
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (1, 'jpg', '2019', 'Lorem ipsum dolor sit amet.', 'As Associate Dean of Students/Senior Advisor to the Dean, “Dr. Renee” focuses on campus climate issues.', 'Through her work with student communities, Renee Alexander’s efforts improve dialogue, collaboration, and understanding. Under her leadership, the Breaking Bread initiative – which brings participants together for a special meal and facilitated conversation – won the highly acclaimed Perkins Prize (2017) for its significant impact toward furthering the ideal of university community while respecting the values of racial and cultural diversity. Her contributions also include facilitating Town Hall meetings, convening the Leadership Roundtable of campus student leaders, working within and between groups to foster community and confront complex issues, resolving conflicts, advising students, and supporting students as they engage across the spectrum of Cornell communities.');
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (2, 'jpg', '1953', 'Lorem ipsum dolor sit amet.', 'Dr.Renee photographed on her 1st birthday.', 'Dr, Renee was born in Buffalo, NY to a happy home on September 19th 1952. She was raised by her mother who was a school teacher, her father who was a veteran, and her grandmother who worked as a maid for an upper class family in New York. She recalls spending a lot of time with her grandmother when her mother and father were off at work.');
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (3, 'jpg', '1955', 'Lorem ipsum dolor sit amet.', 'Dr.Renee as a toddler.', 'Renee has an older brother named Joseph and a younger brother named David. Growing up both the only girl and the middle child, Renee recalls often being smothered with attention or completely ignored. She says it was a strange phenomenon and probably contributed to why she is so chatty and high energy. She had a happy childhood and holds sweet memories of simpler times.');
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (4, 'jpg', '1957', 'Lorem ipsum dolor sit amet.', 'Dr.Renee as a child.', 'Growing up, Renee attended elementary school in Buffalo and quickly developed a passion for speaking to people and speaking publicly. She was always described as "bubbly and charismatic" by the adults in her life and the "life of the party" by her peers and close friends. "When I was younger, all I ever wanted to do was be on TV!" Renee muses.');
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (5, 'PNG', '1965', 'Lorem ipsum dolor sit amet.', 'Practicing the “7 UP”on a dance team. (From left to right Malyssa Brown, Dr. Renee Alexander, Jeane Butler, Talia Nesbourne, Carlton King.)', 'Dr.Renee with her posee get ready for a weekend gig. Renee loved dancing and loved performing even more (still does to this day.) "For me it was just about expression. I would not trade all the bonds and relationships I made on that team for the world."');
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (6, 'jpg', '1967', 'Lorem ipsum dolor sit amet.', 'A young Renee is photographed with some of her best friends by their dorms on campus. (From left to right Malyssa Brown, Dr. Renee Alexander, Jeane Butler, Michael T. Simons.)', 'Renee remembers Cornell being where she met most of the friends that she keeps in touch with today. "Cornell gave me connections, but more importantly, it gave me friends that turned into family."');
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (7, 'PNG', '1971', 'Lorem ipsum dolor sit amet.', 'Rockland State Park: Cornell “Rough Riders” hanging in the summer time. (From left to right Grace Perch, Will Manta, Olivia McCarter, Indie Anderson, Dr. Renee Alexander, Cynthia Ealy, John Hugh, Michael Robinson, Sean Mudd, Carlton King.)', 'Dr. Renee enjoys some time with a group of friends. Renee describes her college experience as enlightening, but not without hiccups. Being African American at an institution like Cornell, Renee and many others were faced with overt racism, prejudices, and an overall less inclucive environment than Cornell students have and enjoy on campus today. In this photo she stands beside some of her firneds who were present at the Willard Straight Take Over in 1969. It was extremely important to Renee that she contribute to changing the campuc climate and positively transform the mindset student body.');
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (8, 'PNG', '1974', 'Lorem ipsum dolor sit amet.', 'Dr.Renee at her college graduation (June 3).', 'A Cornellian, Dr. Alexander earned her B.A. in American History and Government, from the College of Arts and Sciences. She earned her MS.Ed in Counseling from Hunter College/CUNY, and Doctor of Philosophy from the Graduate School of Education at Fordham University in Educational Psychology. "I returned to Cornell in 2006 as Director of Diversity Alumni Programs. In 2010 I was appointed Associate Dean of Students and founding director of 626 Thurston.
What inspires my work in student communities? Contributing to the growth and transformation of emerging adults." -Renee');
INSERT INTO `about_images`(id, img_ext, year, title, description, caption) VALUES (9, 'PNG', '2018', 'Lorem ipsum dolor sit amet.', 'TedxCornell: Campus Climate & Breaking Bread at Cornell University.', 'Last year, Dr.Renee spoke at a Tedx Talk hosted on Cornell campus about a topic that is very near and dear to her. She passionately spoke about the work that needed to be done on campus to create a more inclusive campus environment. Her efforts have improved dialogue, collaboration, and understanding among students of different groups on campus. This talk was given at a TEDx event using the TED conference format but independently organized by a local community. ');



COMMIT;