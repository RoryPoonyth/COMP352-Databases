-- First, calculate the upcoming Sunday (current week) and the Sunday of the following week
SET @today = CURDATE();
SET @start_of_week = DATE_SUB(@today, INTERVAL (DAYOFWEEK(@today) - 1) DAY); -- Last Sunday
SET @end_of_week = DATE_ADD(@start_of_week, INTERVAL 7 DAY); -- Next Sunday

-- Now, get the session details and insert them into the Email_Log table
INSERT INTO `Email_Log` (
    `email_date`,
    `sender`,
    `recipient`,
    `cc_list`,
    `subject`,
    `body_preview`
)
SELECT
    -- Send the email on Sunday
    @start_of_week AS email_date,
    'notifications@myvc.ca' AS sender,  -- Sender's generic email
    cm.email_address AS recipient,      -- Club member's email
    cm.email_address AS cc_list,        -- Club member's email in CC
    CONCAT('Team ', sp.team_id, ' ', s.session_type, ' ', DATE_FORMAT(s.session_date, '%d-%b-%Y'), ' ', DATE_FORMAT(s.session_time, '%h:%i %p')) AS subject,  -- Construct subject
    CONCAT(
        cm.first_name, ' ', cm.last_name, ', ',   -- Club member's name
        sp.player_position, ' ', DATE_FORMAT(s.session_date, '%d-%b-%Y')  -- Player position and session date
    ) AS body_preview
FROM
    `Session_Player` sp
JOIN `Session` s ON s.session_id = sp.session_id
JOIN `ClubMember` cm ON cm.club_member_number = sp.club_member_number
WHERE
    -- Filter sessions scheduled in the upcoming week
    s.session_date BETWEEN @start_of_week AND @end_of_week;
