<?php

/*
 * Query to export member database

SELECT
    CONCAT('RMN-',LPAD(`user_id`,4,'0'),'-',IFNULL(DATE_FORMAT(`application_date`,'%y'),DATE_FORMAT(`registration_date`,'%y')),IF(`honorary`=1,'-H','')) AS member_id,
    first_name,
    middle_name,
    last_name,
    suffix,
    users.address1,
    users.address2,
    users.city,
    users.state AS state_province,
    users.zip AS postal_code,
    users.country,
    phone AS phone_number,
    email AS email_address,
    pass AS password,
    dob,
    IFNULL(
        rank_code,
        CASE branch
            WHEN 5 THEN 'C-1'
            ELSE 'E-1'
            END
    ) AS grade,
    CASE branch
        WHEN 1 THEN 'RMN'
        WHEN 2 THEN 'RMA'
        WHEN 3 THEN 'RMMC'
        WHEN 4 THEN 'GSN'
        WHEN 5 THEN 'CIVIL'
        WHEN 6 THEN 'RHN'
        WHEN 7 THEN 'IAN'
    END AS branch,
    ship_name,
    b1.name as primary_billet,
    b2.name as secondary_billet,
    registration_date,
    application_date,
    active
FROM
    users
LEFT JOIN
    rank_map_all on (users.user_level = rank_map_all.user_level AND branch=branch_id)
LEFT JOIN
    ships using (ship_id)
LEFT JOIN
    billets AS b1 on billet_id1 = b1.id
LEFT JOIN
    billets AS b2 on billet_id2=b2.id
ORDER BY
    ship_name

 */
class UserSeeder extends Seeder {

	public function run()
	{
        DB::collection( 'users' )->delete();
	}

}