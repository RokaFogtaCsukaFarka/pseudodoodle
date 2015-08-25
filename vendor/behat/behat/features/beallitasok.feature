Feature: Custom Preferences options are set in 
	In order to achieve different goals at the polls
	
Scenario: Igen - Nem - Talán option
	Given on page beallitasok.php the YNM option is checked
	Then I should see it appear on szavazas.php
	
Scenario: One vote per person option
	Given on page beallitasok.php the the One vote per person option is checked
	Then it should appear in szavazas.php
	
Scenario: One vote per date
	Given on page beallitasok.php the one vote per date is checked
	Then I should see it appear on szavazas.php
	
Scenario: Requiry for a valid email
	Given on page beallitasok.php the the Requiry for a valid email option is checked
	Then it should appear in szavazas.php
	
