WITH RECURSIVE month_series AS (
    -- Start with the first date of the month, February 1, 2007
    SELECT '2007-02-01' AS month_start
    UNION ALL
    -- Add 1 month to each previous month's date
    SELECT DATE_ADD(month_start, INTERVAL 1 MONTH)
    FROM month_series
    -- Stop at April 1, 2025
    WHERE month_start < '2025-04-01'
),
users_turned_18 AS (
    -- For each month, find users who turned 18 on the first day of the previous month
    SELECT
        cm.club_member_number,
        cm.first_name,
        cm.last_name,
        cm.birth_date,
        cm.email_address,
        ms.month_start,
        -- Calculate the age on the first day of the previous month
        TIMESTAMPDIFF(YEAR, cm.birth_date, DATE_SUB(ms.month_start, INTERVAL 1 MONTH)) AS age_on_prev_month
    FROM 
        month_series ms
    JOIN 
        ClubMember cm
    ON 
        TIMESTAMPDIFF(YEAR, cm.birth_date, DATE_SUB(ms.month_start, INTERVAL 1 MONTH)) = 18
)
-- Now insert into the Email_Log table
INSERT INTO `Email_Log` (
    `email_date`,
    `sender`,
    `recipient`,
    `cc_list`,
    `subject`,
    `body_preview`
)
SELECT
    u.month_start AS email_date,            -- Using the iterator month as email date
    'notifications@myvc.ca' AS sender,     -- Generic sender email
    u.email_address AS recipient,          -- User's email address as recipient
    u.email_address AS cc_list,            -- User's email address as CC list
    'MYVC Account Deactivation' AS subject, -- Fixed subject
    CONCAT('Dear ', u.first_name, ' ', u.last_name, ',\n\nYour account has been deactivated. Please contact support for more information.\n\nThank you.') AS body_preview  -- Body message
FROM
    users_turned_18 u
GROUP BY
    u.club_member_number, u.first_name, u.last_name, u.birth_date, u.email_address, u.month_start;
