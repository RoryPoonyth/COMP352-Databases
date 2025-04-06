SELECT
    fm.FirstName AS FamilyFirstName,
    fm.LastName AS FamilyLastName,
    fm.DateOfBirth AS FamilyBirthDate,
    fm.SocialSecurityNumber AS FamilySSN,
    fm.Address AS FamilyAddress,
    cm.MembershipNumber AS ClubMemberID,
    cm.FirstName AS ClubFirstName,
    cm.LastName AS ClubLastName,
    cm.DateOfBirth AS ClubBirthDate,
    cml.LocationID
FROM FamilyMember fm
JOIN FamilyMember_ClubMember fmc ON fm.SocialSecurityNumber = fmc.FamilyMemberSSN
JOIN ClubMember cm ON fmc.ClubMemberID = cm.MembershipNumber
JOIN ClubMemberLocation cml ON cm.MembershipNumber = cml.ClubMemberMembershipNumber
ORDER BY fm.FirstName, fm.LastName

