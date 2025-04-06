CREATE TABLE Personnel
(
  FirstName         VARCHAR(100) NOT NULL,
  LastName          VARCHAR(100) NOT NULL,
  DateOfBirth       DATE         NOT NULL,
  SocialSecurityNumber VARCHAR(15) NOT NULL,
  MedicareCardNumber VARCHAR(15) NOT NULL,
  TelephoneNumber   VARCHAR(20)  NULL,
  Address           VARCHAR(255) NULL,
  City              VARCHAR(100) NULL,
  Province          VARCHAR(100) NULL,
  PostalCode        VARCHAR(10)  NULL,
  EmailAddress      VARCHAR(150) NULL,
  Role              VARCHAR(50)  NOT NULL,
  Mandate           VARCHAR(50)  NOT NULL,
  PRIMARY KEY (SocialSecurityNumber),
  UNIQUE (MedicareCardNumber)
);

CREATE TABLE Location
(
  LocationID      INT          NOT NULL AUTO_INCREMENT,
  Type            VARCHAR(50)  NOT NULL,
  Name            VARCHAR(100) NOT NULL,
  Address         VARCHAR(255) NOT NULL,
  City            VARCHAR(100) NOT NULL,
  Province        VARCHAR(100) NOT NULL,
  PostalCode      VARCHAR(10)  NOT NULL,
  PhoneNumber     VARCHAR(20)  NULL,
  WebAddress      VARCHAR(255) NULL,
  MaxCapacity     INT          NOT NULL,
  PRIMARY KEY (LocationID)
);

CREATE TABLE Personnel_Location
(
  PersonnelSSN    VARCHAR(15) NOT NULL,
  LocationID      INT         NOT NULL,
  StartDate       DATE        NOT NULL,
  EndDate         DATE        NULL,
  PRIMARY KEY (PersonnelSSN, LocationID, StartDate)
);

ALTER TABLE Personnel_Location
  ADD CONSTRAINT FK_Personnel_TO_Personnel_Location
    FOREIGN KEY (PersonnelSSN)
    REFERENCES Personnel (SocialSecurityNumber);

ALTER TABLE Personnel_Location
  ADD CONSTRAINT FK_Location_TO_Personnel_Location
    FOREIGN KEY (LocationID)
    REFERENCES Location (LocationID);

CREATE TABLE FamilyMember
(
  FirstName         VARCHAR(100) NOT NULL,
  LastName          VARCHAR(100) NOT NULL,
  DateOfBirth       DATE         NOT NULL,
  SocialSecurityNumber VARCHAR(15) NOT NULL,
  MedicareCardNumber VARCHAR(15) NOT NULL,
  TelephoneNumber   VARCHAR(20)  NULL,
  Address           VARCHAR(255) NULL,
  City              VARCHAR(100) NULL,
  Province          VARCHAR(100) NULL,
  PostalCode        VARCHAR(10)  NULL,
  EmailAddress      VARCHAR(150) NULL,
  PRIMARY KEY (SocialSecurityNumber),
  UNIQUE (MedicareCardNumber)
);

CREATE TABLE ClubMember
(
  MembershipNumber INT          NOT NULL AUTO_INCREMENT,
  FirstName        VARCHAR(100) NOT NULL,
  LastName         VARCHAR(100) NOT NULL,
  DateOfBirth      DATE         NOT NULL,
  Height           DECIMAL(5,2) NULL,
  Weight           DECIMAL(5,2) NULL,
  SocialSecurityNumber VARCHAR(15) NOT NULL,
  MedicareCardNumber VARCHAR(15) NOT NULL,
  TelephoneNumber   VARCHAR(20)  NULL,
  Address           VARCHAR(255) NULL,
  City              VARCHAR(100) NULL,
  Province          VARCHAR(100) NULL,
  PostalCode        VARCHAR(10)  NULL,
  ActiveStatus      BOOLEAN      NOT NULL,
  PRIMARY KEY (MembershipNumber),
  UNIQUE (SocialSecurityNumber),
  UNIQUE (MedicareCardNumber)
);

CREATE TABLE FamilyMember_ClubMember
(
  ClubMemberID     INT         NOT NULL,
  FamilyMemberSSN  VARCHAR(15) NOT NULL,
  Relationship     VARCHAR(50) NOT NULL,
  StartDate        DATE        NOT NULL,
  EndDate          DATE        NULL,
  PRIMARY KEY (ClubMemberID, FamilyMemberSSN, StartDate)
);

ALTER TABLE FamilyMember_ClubMember
  ADD CONSTRAINT FK_ClubMember_TO_FamilyMember_ClubMember
    FOREIGN KEY (ClubMemberID)
    REFERENCES ClubMember (MembershipNumber);

ALTER TABLE FamilyMember_ClubMember
  ADD CONSTRAINT FK_FamilyMember_TO_FamilyMember_ClubMember
    FOREIGN KEY (FamilyMemberSSN)
    REFERENCES FamilyMember (SocialSecurityNumber);

CREATE TABLE Payment
(
  PaymentID        INT         NOT NULL AUTO_INCREMENT,
  ClubMemberID     INT         NOT NULL,
  PaymentDate      DATE        NOT NULL,
  Amount           DECIMAL(10,2) NOT NULL,
  Method           VARCHAR(50)  NOT NULL,
  MembershipYear   INT         NOT NULL,
  InstallmentNumber INT        NOT NULL,
  PRIMARY KEY (PaymentID)
);

ALTER TABLE Payment
  ADD CONSTRAINT FK_ClubMember_TO_Payment
    FOREIGN KEY (ClubMemberID)
    REFERENCES ClubMember (MembershipNumber);

CREATE TABLE Team
(
  TeamID           INT          NOT NULL AUTO_INCREMENT,
  Gender           VARCHAR(10)  NOT NULL,
  LocationID       INT          NOT NULL,
  PRIMARY KEY (TeamID)
);

ALTER TABLE Team
  ADD CONSTRAINT FK_Location_TO_Team
    FOREIGN KEY (LocationID)
    REFERENCES Location (LocationID);