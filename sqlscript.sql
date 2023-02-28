/* Start of Phase 3 Script for Group 8
   Authors: Codi Chun, Raz Consta, Damien Cruz, Ryan MacLeod
   T CSS 445, Winter 2023 */

/* CREATE TABLE Queries formatted using https://codebeautify.org/sqlformatter
   Queries 1-10 formatted using https://www.dpriver.com/pp/sqlformat.htm to ensure
                                                 consistency among the 4 authors */

/*  ******************************** 
    Project Phase III 
    Group 8 (LiveSQL) 
    This SQL Script was tested on 
    Oracle LiveSQL. To run, simply 
    load this script file and run.  
    ******************************** */
-- *********************************************************************************  
/* Part A) DDL Statements for Creating 5 Tables

   also included are:
   - at least four CHECK constraints,  
   - at least four attributes with initial default values  
   - all  proper  ON  DELETE  or  ON  UPDATE  clauses  (having  proper  options)  
     associated  with  all  of  the  defined foreign keys. */ 
-- ********************************************************************************* 
-- Create Pet Owner Table
-- ****************************************************************
CREATE SEQUENCE po_seq START WITH 1001 INCREMENT BY 1;

CREATE TABLE PET_OWNER (
  Client_ID INT PRIMARY KEY, 
  Name VARCHAR(15) NOT NULL, 
  Phone VARCHAR(14), 
  Email VARCHAR(30), 
  Address VARCHAR(30), 
  Note VARCHAR(128)
);


CREATE TRIGGER po_trig 
BEFORE INSERT ON PET_OWNER 
FOR EACH ROW 
BEGIN 
  SELECT po_seq.NEXTVAL INTO :new.Client_ID FROM dual; 
END; 
/

-- Create Cut Card Table
-- ****************************************************************
CREATE SEQUENCE cut_card_seq START WITH 2001 INCREMENT BY 1;

CREATE TABLE CUT_CARD(
  Card_ID INT PRIMARY KEY, 
  Bath_Brush_Notes VARCHAR(128), 
  Trim_Tidy_Notes VARCHAR(128), 
  Full_Groom_Notes VARCHAR(128), 
  Nail_Clip_Notes VARCHAR(128), 
  Previous_Appointment_Date DATE, 
  Previous_Service INT
);

CREATE TRIGGER cut_card_trig 
BEFORE INSERT ON CUT_CARD 
FOR EACH ROW 
BEGIN 
  SELECT cut_card_seq.NEXTVAL INTO :new.Card_ID FROM dual; 
END; 
/

-- Create Services Table
-- ****************************************************************
CREATE SEQUENCE services_seq START WITH 4001 INCREMENT BY 1;

CREATE TABLE SERVICES(
  Service_ID INT NOT NULL, 
  Service VARCHAR(20) NOT NULL, 
  Cost NUMBER(7, 2) NOT NULL, 
  Type VARCHAR(10), 
  Difficulty VARCHAR(10), 
  PRIMARY KEY(Service_ID), 
  CHECK (Cost >= 0)
);

CREATE TRIGGER services_trig 
BEFORE INSERT ON SERVICES 
FOR EACH ROW 
BEGIN 
  SELECT services_seq.NEXTVAL INTO :new.Service_ID FROM dual; 
END; 
/

-- Create Pet Table
-- ****************************************************************
CREATE SEQUENCE pet_seq START WITH 3001 INCREMENT BY 1;

CREATE TABLE PET(
  Pet_ID INT NOT NULL, 
  Name VARCHAR(15) NOT NULL, 
  Owner_ID INT, 
  Breed VARCHAR(20), 
  Birthday Date, 
  Weight DECIMAL(10, 2) NOT NULL, 
  Cut_Card INT, 
  Microchipped VARCHAR(20), 
  Rabies_Vaccine VARCHAR(20), 
  Note VARCHAR(128), 
  PRIMARY KEY (Pet_ID), 
  FOREIGN KEY (Owner_ID) REFERENCES PET_OWNER(Client_ID) ON DELETE CASCADE, 
  FOREIGN KEY (Cut_Card) REFERENCES CUT_CARD(Card_ID) ON DELETE CASCADE, 
  CHECK (Birthday >= date '2002-12-31'), 
  CHECK (Weight < 100)
);


CREATE TRIGGER pet_trig 
BEFORE INSERT ON PET 
FOR EACH ROW 
BEGIN 
  SELECT pet_seq.NEXTVAL INTO :new.Pet_ID FROM dual; 
END; 
/

-- Create Appointment Table
-- ****************************************************************
CREATE SEQUENCE appt_seq START WITH 5001 INCREMENT BY 1;

CREATE TABLE APPOINTMENT(
  Appointment_ID INT NOT NULL, 
  Appointment_date DATE DEFAULT CURRENT_DATE, 
  Start_Time VARCHAR(20) NOT NULL, 
  End_Time VARCHAR(20), 
  Client_ID INT, 
  Pet_ID INT NOT NULL, 
  Service_id INT NOT NULL, 
  PRIMARY KEY(Appointment_ID), 
  FOREIGN KEY(Client_ID) REFERENCES PET_OWNER(Client_ID) ON DELETE CASCADE, 
  FOREIGN KEY(Pet_ID) REFERENCES PET(Pet_ID) ON DELETE CASCADE, 
  FOREIGN KEY(Service_id) REFERENCES SERVICES(Service_ID) ON DELETE CASCADE, 
  CHECK (End_Time > Start_Time)
);

CREATE TRIGGER appt_trig 
BEFORE INSERT ON APPOINTMENT 
FOR EACH ROW 
BEGIN 
  SELECT appt_seq.NEXTVAL INTO :new.Appointment_ID FROM dual; 
END; 
/

-- *********************************************************************************  
-- Part B) Sample Data
-- ********************************************************************************* 

-- Data for Pet Owner table 
-- Summary: Stores information about the pet owner name(client), 
-- phone, email, address, and a note

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Thomas Hills', '(888)456-7891', 'thill91@gmail.com', '10 Street SW Kent, WA', '');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Linda Martin', '(253)318-3211', 'lmar11@hotmail.com', '222 Alberta Dr. SE Tacoma, WA', '');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Ryan MacLeod', '(253)819-3874', 'rmac74@gmail.com', '345 Lucas Rd. E Tukwilla, WA', 'Friend Discount');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Debra Thomas', '(253)498-1111', 'dtho11@iCloud.com', '8045 Yakima Ave. Tacoma, WA', '');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Kyler Robinson', '(360)941-8431', 'krob31@gmail.com', '30 House St. Olympia, WA', '');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Tabitha Leery', '(360)649-1634', 'tlee34@msn.com', '88 Livehere Dr. Tacoma, WA', 'Met through Facebook');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Erica Simpson', '(253)946-1347', 'esim47@aol.com', '901 Tulip Dr. Puyallup, WA', '');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Jessica Rabbit', '(425)971-2314', 'jrab14@iCloud.com', '311 Radius Ln. W Tacoma, WA', 'Don''t call after 6 pm');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Clinton Rowe', '(253)941-6167', 'crow67@hotmail.com', '69 Real Rd. Tacoma, WA', '');

INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('John Doe', '(360)645-3397', 'jdoe97@hotmail.com', '343 Halo Dr. Bellevue, WA', '');

-- ****************************************************************

-- Data for Services table 
-- Summary: Stores information about the services offered by the business:
-- service name, service cost (in US Dollars), 
-- service type (Non-Groom and Groom for now), and difficulty (1 - 4)

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Nail Clip', 5, 'Non-Groom', '1');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Nail Clip', 10, 'Non-Groom', '2');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Bath/Brush', 15,	'Non-Groom', '1');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Bath/Brush', 20, 'Non-Groom', '2');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Bath/Brush', 25, 'Non-Groom', '3');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Bath/Brush', 30,	'Non-Groom', '4');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Trim/Tidy', 20, 'Groom', '1');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Trim/Tidy', 25, 'Groom', '2');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Trim/Tidy', 30, 'Groom', '3');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Trim/Tidy', 35, 'Groom', '4');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Full Groom', 30, 'Groom', '1');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Full Groom', 40,	'Groom', '2');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Full Groom', 50,	'Groom', '3');

INSERT INTO SERVICES(Service, Cost, Type, Difficulty) 
VALUES ('Full Groom', 60,	'Groom', '4');

-- ****************************************************************

-- Data for Cut Card table 
-- Summary: Stores information about each pet's cut card:
-- bath/brush notes, trim/tidy notes, full groom notes, nail clip notes,
-- previous appointment date, previous service id

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Hypo Allergenic Shampoo', 'Use #4 Blade - C Comb', 'Use #3 Blade - B Comb', 'Hates nails being clipped', DATE '2023-01-22', 4013);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Organic Green Tea Shampoo - Might bite', 'Use #3 Blade - A Comb', 'Use #7 Blade - B Comb', 'Hates nails being clipped', DATE '2023-01-02', 4013);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Doesn''t like blowdryer', 'Use #3 Blade - B Comb', 'Use #6 Blade - B Comb', 'Hates nails being clipped', DATE '2023-12-22', 4013);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Loves to lick water', 'Use #7 Blade - A Comb', 'Use #7 Blade - C Comb', 'Pulls away', DATE '2023-02-01', 4007);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Pulls away', 'Use #6 Blade - C Comb', 'Use #6 Blade - B Comb', 'Hates nails being clipped', DATE '2023-01-27', 4007);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Likes baths', 'Use #6 Blade - B Comb', 'Use #5 Blade - B Comb', 'Hates nails being clipped', DATE '2023-01-15', 4010);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Howls', 'Use #1 Blade - C Comb', 'Use #5 Blade - C Comb', 'Has dewclaw', DATE '2023-01-07', 4011);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Owner brings shampoo', 'Use #4 Blade - C Comb', 'Use #5 Blade - B Comb', 'Hates nails being clipped', DATE '2023-01-14', 4010);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Don''t blow dry face - Use Allergenic shampoo', 'Use #6 Blade - B Comb', 'Use #3 Blade - A Comb', 'Hates nails being clipped', DATE '2023-02-04', 4012);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Owner brings shampoo', 'Use #6 Blade - A Comb', 'Use #1 Blade - A Comb', 'Might bite', DATE '2022-12-10', 4011);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Loves baths', 'Use #7 Blade - A Comb', 'Use #5 Blade - C Comb', 'Hates nails being clipped', DATE '2023-02-04', 4002);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Hates baths', 'Use #1 Blade - B Comb', 'Use #7 Blade - B Comb', 'Hates nails being clipped', DATE '2023-02-04', 4003);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Pulls away during feet', 'Use #4 Blade - B Comb', 'Use #6 Blade - C Comb', 'Ok', DATE '2023-01-08', 4002);

INSERT INTO CUT_CARD (Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes, Previous_Appointment_Date, Previous_Service) 
VALUES ('Don''t get water close to eyes, will panic', 'Use #3 Blade - A Comb', 'Use #3 Blade - A Comb', 'Ok', DATE '2022-12-18', 4009);

-- ****************************************************************

-- Data for Pet table
-- Summary: Stores information about the pets:
-- pet name, owner id, pet breed, pet birthday, pet weight (in lbs), 
-- cut card id, microchipped (yes/no), rabies vaccine (yes/no), note

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Tarzan', 1001, 'Tabby', DATE '2011-1-11', 6, 2005, 'Yes', 'Yes', 'Friendly old orange cat');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Nirvana', 1002, 'Beagle-Chihuaua', DATE '2010-2-28', 15,	2001, 'Yes', 'Yes', 'Has Mastitis');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Oasis', 1002, 'Dotson', DATE '2020-4-15', 10, 2004, 'No', 'Yes', 'Separation anxiety');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Lefty', 1003, 'Frenchton', DATE'2022-6-12', 30, 2002, 'Yes', 'Yes', 'Pees when scared');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Skipper', 1003, 'Beagle', DATE '2020-9-17', 17, 2013, 'Yes', 'No', 'Great dog!');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Penny', 1004, 'Poodle', DATE '2018-8-22', 58, 2010, 'No', 'Yes', 'Allergic to chicken');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Luna', 1005, 'Calico', DATE '2016-7-25', 7, 2011, 'Yes', 'Yes', 'Tuna''s sister');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Tuna', 1005, 'Calico', DATE '2016-7-25',	12,	2012, 'Yes', 'Yes', 'Luna''s brother');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Gadhar', 1006, 'Australian Shephard', DATE '2012-12-12', 36, 2008, 'No',	'Yes', '');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Joe Dirt', 1007,	'Tabby', DATE '2017-10-31', 8, 2006, 'Yes', 'Yes', 'Might try to run away');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Lucky', 1008, 'Calico', DATE '2021-7-6', 8, 2003, 'Yes', 'Yes', 'No treats');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Scout', 1009, 'Pit Bull', DATE '2015-6-1', 47, 2009, 'No', 'Yes', 'Broke a foot 2 years ago');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Fannie', '1010', 'Pomeranian', DATE '2008-5-8',12, 2007,	'Yes', 'Yes', '');

INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Buddy', '1010', 'Yorkie', DATE '2023-1-2', 1, 2014, 'Yes', 'No', 'Puppy');

-- ****************************************************************

-- Data for Appointment table
-- Summary: Stores information about appointments:
-- appointment date, start time, end time, 
-- client id, pet id, service id

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-10', '14:30', '15:00', 1009, 3009, 4006);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-10', '15:30', '17:00', 1007, 3006, 4014);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-11', '11:30', '14:00', 1006, 3008, 4013);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-12', '11:30', '12:30', 1001, 3005, 4004);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-12', '13:30', '15:00', 1010,	3007, 4011);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-12', '15:30', '15:45', 1002,	3001, 4002);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-18', '10:00', '10:15', 1005,	3011, 4002);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-18', '10:30' ,'12:00', 1003, 3002, 4010);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-19', '14:00', '15:45', 1004,	3010, 4008);

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id) 
VALUES (DATE '2023-2-19', '15:30', '16:00', 1008,	3003, 4001);

-- Displaying the 5 tables that were created.
select * from pet_owner;
select * from cut_card;
select * from pet;
select * from services;
select * from appointment;

-- *********************************************************************************  
-- Part C) SQL Queries
-- ********************************************************************************* 

/*****************************************************************
Query 1
Purpose: Getting the “Full Groom Notes” for all the pets of an owner with a given name.

Expected: A table containing tuples with the pet name and full groom notes for that pet, 
          for all pets of a given pet owner.
*****************************************************************/
SELECT pet.NAME                  AS "Pet Name",
       cut_card.full_groom_notes AS "Full Groom Notes"
FROM   cut_card
       JOIN pet
         ON cut_card.card_id = pet.cut_card
       JOIN pet_owner
         ON pet.owner_id = pet_owner.client_id
WHERE  pet_owner.NAME = 'Linda Martin'; 


/*****************************************************************
Query 2
Purpose: List the number of pets per each breed that are not microchipped 
         or do not have the rabies vaccine. This can be used as statistical 
         output of what percentage of pets per breed are not microchipped or not vaccinated.

Expected: A table containing tuples with the breed name and number of pets 
          of that breed that are not microchipped or not vaccinated.
*****************************************************************/
SELECT pet.breed        AS "Breed",
       Count(pet.breed) AS "Numbers of pets not microchipped or not vaccinated"
FROM   pet
WHERE  pet.breed IN (SELECT pet.breed
                     FROM   pet
                     WHERE  pet.microchipped = 'No')
        OR pet.breed IN (SELECT pet.breed
                         FROM   pet
                         WHERE  pet.rabies_vaccine = 'No')
GROUP  BY pet.breed
ORDER  BY pet.breed ASC; 

/*****************************************************************
Query 3
Purpose: Retrieve Owner information for pets who haven’t had any 
         appointments in the last month and have no scheduled 
         appointments. This information can be used to send 
         offers/reminders to clients who are due to make new appointments

Expected: A table containing tuples with the pet name, owner name, 
          owner phone number, and owner email, for those pets who 
          haven’t had any appointments in the last month and have 
          no scheduled appointments.
*****************************************************************/
SELECT P.NAME   AS "Pet Name",
       PO.NAME  AS "Owner Name",
       PO.phone AS "Owner Phone Number",
       PO.email AS "Owner Email"
FROM   pet P
       JOIN pet_owner PO
         ON PO.client_id = P.owner_id
WHERE  P.cut_card IN (SELECT card_id
                      FROM   cut_card CC
                      WHERE  CC.previous_appointment_date < sysdate - 30)
       AND P.pet_id NOT IN (SELECT pet_id
                            FROM   appointment)
ORDER  BY P.NAME ASC; 

/*****************************************************************
Query 4
Purpose: Retrieve the required information for email/text and 
         appointment reminder. The reminder will take the form 
         "Hello <> your pet <> is scheduled for an appointment on <> at <>, See you soon"

Expected: A table containing tuples with the appointment date, 
          start time, pet name, owner name, owner phone number and owner email.
*****************************************************************/
SELECT appointment.appointment_date AS "Appointment Date",
       appointment.start_time       AS "Start Time",
       pet.NAME                     AS "Pet Name",
       pet_owner.NAME               AS "Owner Name",
       pet_owner.phone              AS "Owner Phone Number",
       pet_owner.email              AS "Owner Email"
FROM   appointment
       FULL OUTER JOIN pet
                    ON appointment.pet_id = pet.pet_id
       FULL OUTER JOIN pet_owner
                    ON pet.owner_id = pet_owner.client_id
WHERE  appointment.appointment_date >= sysdate - 1
       AND appointment.appointment_date < sysdate + 7
ORDER  BY "Appointment Date" ASC; 

/*****************************************************************
Query 5
Purpose: Get the list of all pets that weigh less than the average 
         weight of all pets, but are not the pet that weighs the least. 
         Those pets can be used as training for a new employee in the 
         pet grooming business (a new employee should not take care of 
         the lightest pet or those that weigh more than the average).

Expected: A table containing tuples with all the information 
          (Pet id, Name, Owner id, Breed, Birthday, Weight, 
          Cut_card, Microchipped, Rabies_Vaccine, Note) about 
          pets that weigh less than the average weight of all pets.
*****************************************************************/
SELECT *
FROM   pet
MINUS
SELECT *
FROM   pet
WHERE  pet.weight >= (SELECT Avg(pet.weight)
                      FROM   pet)
        OR pet.weight = (SELECT Min(pet.weight)
                         FROM   pet); 

/*****************************************************************
Query 6
Purpose: Get a list of Pet_Owner info for pets that have birthdays 
         today to send out a birthday offer for 20% off.

Expected: A table containing tuples with the Owner's name, 
          phone number, email, and pet’s name.
*****************************************************************/
SELECT ( pet_owner.NAME ) AS "Owner Name",
       email,
       phone,
       ( pet.NAME )       AS "Pet Name"
FROM   pet
       JOIN pet_owner
         ON client_id = owner_id
WHERE  Extract(month FROM birthday) = Extract(month FROM sysdate)
       AND Extract(day FROM birthday) = Extract(day FROM sysdate); 

/* 
Test Script 1 to check extract
SELECT ( pet_owner.name ) AS "Owner Name",
       email,
       phone,
       ( pet.name )       AS "Pet Name"
FROM   pet
       join pet_owner
         ON client_id = owner_id
WHERE  Extract(month FROM birthday) = Extract(month FROM DATE '2011-1-11')
       AND Extract(day FROM birthday) = Extract(day FROM DATE '2011-1-11'); 
*/

/* 
Test script 2 to check sysdate works
SELECT ( pet_owner.NAME ) AS "Owner Name",
       email,
       phone,
       ( pet.NAME )       AS "Pet Name"
FROM   pet
       JOIN pet_owner
         ON client_id = owner_id
WHERE  2 = Extract(month FROM sysdate)
       AND 13 = Extract(day FROM sysdate); 
*/

/*****************************************************************
Query 7
Purpose: Retrieve a cut card for Lefty (a pet in the database). Used 
         to pull up a pet's cut card for the groomer. The groomer will 
         probably use this when grooming a pet and wanting to look up 
         notes or when they are scheduling the pet and need notes.

Expected: A table containing one tuple that has the name of the pet, 
          and all of the columns from the cut_card schema (excluding card_id).
*****************************************************************/
SELECT name,
       full_groom_notes,
       trim_tidy_notes,
       bath_brush_notes,
       nail_clip_notes,
       previous_appointment_date,
       previous_service
FROM   pet
       JOIN cut_card
         ON cut_card = card_id
WHERE  NAME = 'Lefty'; 

/*****************************************************************
Query 8
Purpose: Count how many times each service has been booked in 
         the past. Helps to see what are the most popular services 
         and helps to grow the business.

Expected: A table containing tuples with the number of times each 
          service has been booked in the past, and all details 
          regarding that service.
*****************************************************************/
SELECT Count(services.service_id) AS "Times Service Booked in the Past",
       services.service_id        AS "Service ID",
       services.service           AS "Service Name",
       services.cost              AS "Service Cost",
       services.type              AS "Service Type",
       services.difficulty        AS "Service Difficulty"
FROM   services
       JOIN appointment
         ON appointment.service_id = services.service_id
GROUP  BY services.service_id,
          services.service,
          services.cost,
          services.type,
          services.difficulty
ORDER  BY Count(services.service_id) DESC; 

/*****************************************************************
Query 9
Purpose: Calculating invoices for the purpose of sending out the 
         invoices to the pet owner’s email.

Expected: A table that shows appointment’s id, pet owner’s name, 
          email, and the cost of each appointment

*****************************************************************/
SELECT appointment_id,
       pet_owner.NAME AS "CLIENT NAME",
       email,
       cost
FROM   appointment
       LEFT JOIN pet_owner
              ON appointment.client_id = pet_owner.client_id
       LEFT JOIN services
              ON appointment.service_id = services.service_id; 

/*****************************************************************
Query 10
Purpose: Count the total number of pets and appointments that each client has.

Expected: A table that shows the client's name, number of pets and total appointments.

*****************************************************************/
SELECT aname AS "CLIENT",
       "# of pets",
       "# of appointments"
FROM   (SELECT pet_owner.NAME    AS ANAME,
               Count(pet.pet_id) "# of pets"
        FROM   pet_owner
               LEFT JOIN pet
                      ON client_id = owner_id
        GROUP  BY pet_owner.NAME)
       LEFT JOIN (SELECT pet_owner.NAME        AS BNAME,
                         Count(appointment_id) "# of appointments"
                  FROM   appointment
                         LEFT JOIN pet_owner
                                ON pet_owner.client_id = appointment.client_id
                  GROUP  BY pet_owner.NAME)
              ON aname = bname; 

-- End of Script (Feb 12, 2022) 

-- New updates on phase 3:
ALTER TABLE APPOINTMENT DROP COLUMN Client_ID;
RENAME SERVICES TO SERVICE;
