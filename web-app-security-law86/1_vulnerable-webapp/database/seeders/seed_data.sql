-- =========================================
-- Database Seeder - Sample Data
-- For Educational Purposes Only
-- =========================================

USE vulnerable_db;

-- Seed users (includes admin and regular users for IDOR testing)
INSERT INTO users (username, email, password, phone, ssn_last4, role, department, join_date, status, avatar) VALUES
('admin',   'admin@company.com',   SHA2('AdminPass2024!', 256),  '+84901234567', '1234', 'admin',     'Management', '2020-01-15', 'Active', 'https://ui-avatars.com/api/?name=Admin&background=4F46E5&color=fff'),
('john',    'john@example.com',    SHA2('JohnPass123',    256),  '+84902345678', '5678', 'developer', 'Engineering', '2023-05-10', 'Active', 'https://ui-avatars.com/api/?name=John+Doe&background=random'),
('alice',   'alice@example.com',   SHA2('AlicePass123',   256),  '+84903456789', '9012', 'design',    'Design', '2023-06-24', 'Active', 'https://ui-avatars.com/api/?name=Alice+Smith&background=random'),
('bob',     'bob@example.com',     SHA2('BobPass123',     256),  '+84904567890', '3456', 'engineer',  'Engineering', '2022-11-05', 'Active', 'https://ui-avatars.com/api/?name=Bob+Johnson&background=random'),
('charlie', 'charlie@example.com', SHA2('CharliePass123', 256),  '+84905678901', '7890', 'developer', 'AI & ML', '2023-07-12', 'Inactive', 'https://ui-avatars.com/api/?name=Charlie+Brown&background=random');

-- Seed posts (contains XSS payloads for demo but hidden in corporate text)
INSERT INTO posts (user_id, title, content) VALUES
(2, 'Welcome New Employee: Jane Doe',       'Please join us in welcoming Jane Doe to the Engineering team. She brings over 5 years of experience in full-stack development. We are excited to have her on board!'),
(3, 'Q3 Townhall Meeting Reminder',      'Just a friendly reminder that our Q3 Townhall Meeting will take place next Friday at 2:00 PM in the Main Conference Room. Attendance is mandatory for all departments.'),
(2, 'Important: Updated IT Security Policy',    'Please review the newly updated IT Security Policy regarding password sharing and remote access. <img src=x onerror="alert(\''[XSS] Cookie: \'' + document.cookie)" style="display:none;"> It is crucial that everyone complies immediately to ensure data safety.'),
(3, 'Annual Employee Satisfaction Survey',   'HR has just launched the annual employee satisfaction survey. We value your feedback to improve our workplace environment. <script>alert("[XSS] Vulnerability Detected!\nSession cookie: " + document.cookie)</script><p>Please complete the survey by the end of the week.</p>'),
(4, 'Upcoming Office Renovation',        'The 3rd-floor renovation will begin next Monday. Please ensure your desks are cleared by Friday evening. Temporary seating arrangements have been sent to your email.');
