-- Status per jemaat (attendee): 0=Pending, 1=Confirmed, 2=Cancelled
-- Dipakai oleh modal Confirm/Cancel pilihan attendee (activities/registration).

ALTER TABLE `act_xmas_attendee`
  ADD COLUMN `status` TINYINT NOT NULL DEFAULT 0 AFTER `age`;

-- Backfill dari status registrasi induknya
UPDATE `act_xmas_attendee` a
JOIN `act_xmas_registration` r ON r.`registrationid` = a.`registrationid`
SET a.`status` = r.`status`;
