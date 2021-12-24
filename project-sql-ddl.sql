-- sqlplus ora_michcqge@stu
-- a94918125
-- start project-sql-ddl.sql
-- change /__/___/
-- run



drop table Manages;
drop table Trains;
drop table Wins;
drop table Invites;
drop table Events_Hosts;
drop table Organizes;
drop table Competes;
drop table ParticipatesIn;
drop table MediaBroadcast_BroadcastedBy;
drop table Funds;
drop table Team;
drop table Athlete;
drop table Medal;
drop table OlympicGames;
drop table Sponsor;
drop table Competitor;
drop table Coach;
drop table Manager;
drop table Sport;
drop table People;

CREATE TABLE Sport(
    sportName CHAR(50) PRIMARY KEY,
    facilityUsed CHAR(50)
);

CREATE TABLE People(
    employeeID INTEGER PRIMARY KEY,
    personName CHAR(50),
    income INTEGER
);

CREATE TABLE Coach(
    employeeID INTEGER PRIMARY KEY,
    age INTEGER,
    FOREIGN KEY(employeeID) REFERENCES People
);

CREATE TABLE Manager(
    employeeID INTEGER PRIMARY KEY,
    company CHAR(50),
    FOREIGN KEY(employeeID) REFERENCES People
);

CREATE TABLE Competitor(
    competitorID INTEGER,
    mannerOfPlay CHAR(20),
    PRIMARY KEY(competitorID)
);
grant select on Competitor to public;

CREATE TABLE OlympicGames(
    year INTEGER,
    location CHAR(50),
    season CHAR(20),
    PRIMARY KEY(year, location) 
);

grant select on OlympicGames to public;

CREATE TABLE Athlete(
    employeeID INTEGER PRIMARY KEY,
    competitorID INTEGER,
    height INTEGER,
    FOREIGN KEY(employeeID) REFERENCES People,
    FOREIGN KEY(competitorID) REFERENCES Competitor
);

-- Weak entity must delete cascade on parent
CREATE TABLE MediaBroadcast_BroadcastedBy(
    msportName CHAR(50),
    companyName CHAR(50),
    mediaType CHAR(20),
    engagement INTEGER,
    PRIMARY KEY(msportName, companyName, mediaType),
    FOREIGN KEY(msportName) REFERENCES Sport ON DELETE CASCADE
);

CREATE TABLE Sponsor(
    companyName CHAR(50),
    yearSponsored INTEGER,
    monetaryAmount INTEGER,
    PRIMARY KEY(companyName, yearSponsored)
);

CREATE TABLE Funds(
    yearSponsored INTEGER,
    companyName CHAR(50),
    competitorID INTEGER,
    PRIMARY KEY(yearSponsored, companyName, competitorID),
    FOREIGN KEY(companyName, yearSponsored) REFERENCES Sponsor ON DELETE CASCADE,
    FOREIGN KEY(competitorID) REFERENCES Competitor
);

CREATE TABLE Team(
    competitorID INTEGER,
    teamName CHAR(50),
    numberOfMembers INTEGER,
    PRIMARY KEY(competitorID, teamName),
    FOREIGN KEY(competitorID) REFERENCES Competitor
);

CREATE TABLE Competes(
    competitorID INTEGER,
    competesportName CHAR(50),
    PRIMARY KEY(competitorID, competesportName),
    FOREIGN KEY(competitorID) REFERENCES Competitor,
    FOREIGN KEY(competesportName) REFERENCES Sport
);


CREATE TABLE ParticipatesIn(
    competitorID INTEGER,
    sportName CHAR(50),
    employeeID INTEGER,
    PRIMARY KEY(competitorID, sportName, employeeID),
    FOREIGN KEY(competitorID) REFERENCES Competitor,
    FOREIGN KEY(sportName) REFERENCES Sport,
    FOREIGN KEY(employeeID) REFERENCES People
);

CREATE TABLE Organizes(
    year INTEGER,
    location CHAR(50), 
    sportName CHAR(50),
    PRIMARY KEY(year, location, sportName),
    FOREIGN KEY(year, location) REFERENCES OlympicGames, 
    FOREIGN KEY(sportName) REFERENCES Sport
);

CREATE TABLE Medal(
    competitionWonAt CHAR(50),
    material CHAR(20),
    compensation INTEGER,
    PRIMARY KEY(competitionWonAt, material)
);

CREATE TABLE Wins(
    competitionWonAt CHAR(50),
    material CHAR(20),
    sportName CHAR(50),
    competitorID INTEGER,
    PRIMARY KEY(competitionWonAt, material, sportName),
    FOREIGN KEY(sportName) REFERENCES Sport,
    FOREIGN KEY(competitionWonAt, material) REFERENCES Medal,
    FOREIGN KEY(competitorID) REFERENCES Competitor
);

CREATE TABLE Invites(
    year INTEGER,
    location CHAR(50),
    employeeID INTEGER,
    PRIMARY KEY(year, location, employeeID),
    FOREIGN KEY(year, location) REFERENCES OlympicGames,
    FOREIGN KEY(employeeID) REFERENCES People
);

CREATE TABLE Manages(
    mEmployeeID INTEGER,
    cEmployeeID INTEGER,
    PRIMARY KEY(mEmployeeID, cEmployeeID),
    FOREIGN KEY (mEmployeeID) REFERENCES Manager,
    FOREIGN KEY (cEmployeeID) REFERENCES Coach
);

CREATE TABLE Trains(
    cEmployeeID INTEGER,
    competitorID INTEGER,
    yearsCoached INTEGER,
    PRIMARY KEY(cEmployeeID, competitorID),
    FOREIGN KEY (cEmployeeID) REFERENCES Coach,
    FOREIGN KEY (competitorID) REFERENCES Competitor
);

-- weak entity
CREATE TABLE Events_Hosts(
    eventName CHAR(50),
    sportName CHAR(50),
    PRIMARY KEY(eventName, sportName),
    FOREIGN KEY(sportName) REFERENCES Sport ON DELETE CASCADE
);

INSERT into People
values(30, 'Roger Man', 20000);

INSERT into People
values(31, 'Elsa Frozen', 23000);

INSERT into People
values(32, 'Ella Frozen', 33000);

INSERT into People
values(33, 'Olaf Frozen', 22000);

INSERT into People
values(34, 'Stan Lee', 21000);

INSERT into People
values(1, 'John Oliver', 50000);

INSERT into People
values(2, 'Oliver Olive', 51000);

INSERT into People
values(3, 'Ted Teddy', 52000);

INSERT into People
values(4, 'Cruz Cuzko', 53000);

INSERT into People
values(5, 'Barack Obama', 54000);

INSERT into People
values(10, 'Jack Laviolette', 40000);

INSERT into People
values(11, 'George Kennedy', 50000);

INSERT into People
values(12, 'Ernest Savard', 30000);

INSERT into People
values(13, 'Cecil Hart', 35000);

INSERT into People
values(14, 'Jules Dugal', 40000);

INSERT into Coach
values(1, 25);

INSERT into Coach
values(2, 35);

INSERT into Coach
values(3, 45);

INSERT into Coach
values(4, 55);

INSERT into Coach
values(5, 65);

INSERT into Manager
values(10, 'Montreal Canadians');

INSERT into Manager
values(11, 'Golden State Warriors');

INSERT into Manager
values(12, 'Boston Celtics');

INSERT into Manager
values(13, 'Montreal Canadians');

INSERT into Manager
values(14, 'Montreal Canadians');

INSERT into Competitor
values(31, 'Individual');

INSERT into Competitor
values(32, 'Team');

INSERT into Competitor
values(33, 'Individual');

INSERT into Competitor
values(34, 'Team');

INSERT into Competitor
values(35, 'Individual');

INSERT into Athlete
values(30, 31, 180);

INSERT into Athlete
values(31, 32, 183);

INSERT into Athlete
values(32, 33, 175);

INSERT into Athlete
values(33, 34, 178);

INSERT into Athlete
values(34, 35, 191);

INSERT into Sport
values('Swimming', 'Pool');

INSERT into Sport
values('Hockey', 'Skating Rink');

INSERT into Sport
values('Track', 'Oval Field');

INSERT into Sport
values('Rowing', 'River');

INSERT into Sport
values('Tennis Doubles', 'Tennis Court');

INSERT into Sport
values('Volleyball', 'Gym Court');

INSERT into MediaBroadcast_BroadcastedBy
values('Hockey', 'CBC', 'News', 100);

INSERT into MediaBroadcast_BroadcastedBy
values('Swimming', 'CBC', 'News', 200);

INSERT into MediaBroadcast_BroadcastedBy
values('Swimming', 'BBC', 'News', 300);

INSERT into MediaBroadcast_BroadcastedBy
values('Rowing', 'Youtube', 'Social Media', 300000);

INSERT into MediaBroadcast_BroadcastedBy
values('Swimming', 'Youtube', 'Social Media', 500000);

INSERT into MediaBroadcast_BroadcastedBy
values('Swimming', 'Amazon PrimeVideo', 'Streaming', 400000);

INSERT into Sponsor
values('RBC', 2018, 1000000);

INSERT into Sponsor
values('Toyota', 2019, 10000);

INSERT into Sponsor
values('Hudson Bay', 2020, 50000);

INSERT into Sponsor
values('Lululemon', 2010, 4000);

INSERT into Sponsor
values('Bell', 2016, 10000);

INSERT into Funds
values(2020, 'Hudson Bay', 31);			
				
INSERT into Funds
values(2020, 'Hudson Bay', 32);

INSERT into Funds
values(2018, 'RBC', 33);

INSERT into Funds
values(2018, 'RBC', 34);

INSERT into Funds
values(2010, 'Lululemon', 35);

INSERT into Team
values(32, 'Mens Hockey', 24);

INSERT into Team
values(34, 'Mens Hockey', 25);

INSERT into Team
values(32, 'Mens Volleyball', 12);

INSERT into Team
values(34, 'Mens Volleyball', 12);

INSERT into OlympicGames
values(2018, 'PyeongChang', 'Winter');

INSERT into OlympicGames
values(2010, 'Vancouver', 'Winter');

INSERT into OlympicGames
values(2012, 'London', 'Summer');

INSERT into OlympicGames
values(2016, 'Rio', 'Summer');

INSERT into OlympicGames
values(2000, 'Sydney', 'Summer');

INSERT into OlympicGames
values(2021, 'Tokyo', 'Summer');

INSERT into Competes
values(31, 'Swimming');

INSERT into Competes
values(32, 'Hockey');

INSERT into Competes
values(33, 'Track');

INSERT into Competes
values(34, 'Volleyball');

INSERT into Competes
values(35, 'Swimming');

INSERT into ParticipatesIn
values(31, 'Swimming', 30);

INSERT into ParticipatesIn
values(32, 'Rowing', 31);

INSERT into ParticipatesIn
values(34, 'Hockey', 32);

INSERT into ParticipatesIn
values(35, 'Tennis Doubles', 33);

INSERT into ParticipatesIn
values(33, 'Swimming', 34);

INSERT into Organizes
values(2018, 'PyeongChang','Hockey');

INSERT into Organizes
values(2012, 'London','Track');

INSERT into Organizes
values(2016, 'Rio','Swimming');

INSERT into Sport
values('Synchronized Swimming', 'Pool');

INSERT into Organizes
values(2000, 'Sydney','Synchronized Swimming');

INSERT into Medal
values('2018 Olympics', 'Gold', 10000);

INSERT into Medal
values('2021 Olympics', 'Bronze', 20000);

INSERT into Medal
values('2018 Olympics', 'Bronze', 1);

INSERT into Medal
values('2016 Olympics', 'Gold', 100000);

INSERT into Medal
values('2014 Olympics', 'Gold', 10000);

INSERT into Medal
values('2008 Olympics', 'Silver', 50000);

INSERT into Medal
values('2012 Olympics', 'Silver', 2);

INSERT into Wins
values('2021 Olympics','Bronze','Swimming', 31);

INSERT into Wins
values('2016 Olympics','Gold','Swimming', 31);

INSERT into Wins
values('2012 Olympics','Silver','Swimming', 31);

INSERT into Wins
values('2014 Olympics','Gold','Hockey', 32);

INSERT into Invites
values(2021,'Tokyo', 2);

INSERT into Invites
values(2021,'Tokyo', 3);

INSERT into Invites
values(2016,'Rio', 4);

INSERT into Invites
values(2010,'Vancouver', 5);

INSERT into Manages
values(10, 1);

INSERT into Manages
values(11, 2);

INSERT into Manages
values(12, 3);

INSERT into Manages
values(13, 4);

INSERT into Manages
values(14, 5);

INSERT into Trains
values(1, 31, 5);

INSERT into Trains
values(2, 32, 2);

INSERT into Trains
values(3, 33, 3);

INSERT into Trains
values(4, 34, 10);

INSERT into Trains
values(5, 35, 2);




-- SQL Queries:

-- DELETE
-- DELETE FROM MediaBroadcast_BroadcastedBy
-- WHERE companyName = 'CBC'

-- UPDATE

-- UPDATE Sport
-- SET facilityUsed='Volleyball Court'
-- WHERE sportName='Volleyball';

-- SELECTION
-- SELECT *
-- FROM Competitor
-- WHERE MannerOfPlay = 'Team';

-- PROJECTION
-- SELECT location
-- FROM OlympicGames
-- WHERE season = 'Winter';

-- JOIN
-- Select all the Canadian athletes that participated in the 2021 Olympics that won a Bronze 
-- SELECT EmployeeID
-- FROM Wins w, Competitor c, Athlete a
-- WHERE w.competitionwonat = ‘2021 Olympics’  AND w.MATERIAL = ‘Bronze’ 
-- AND c.competitorID = w.competitorID AND c.competitorID = a.competitorID

-- AGGREGATION GROUP BY
-- SELECT material, max(compensation)
-- From medal
-- Group by material

-- AGGREGATION HAVING
-- Select companyname, count(*)
-- From funds
-- Group by companyname

-- AGGREGATION NESTED
-- Select avg(engagement), mediaType 
-- From mediabroadcast_broadcastedby
-- Group by mediaType
-- Having avg(engagement) < (select avg(engagement)
-- From mediabroadcast_broadcastedby)
