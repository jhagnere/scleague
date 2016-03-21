<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 22/09/15
 * Time: 02:21
 */

namespace SCLeague\SeasonBundle\Model;


use SCLeague\SeasonBundle\Entity\Season;

interface TeamManagerInterface
{

    /**
     * Create the new entities to persist in DB concerning the season
     * @param Season $season
     * @return
     */
    public function manageTeamsForSeason(Season $season);

}