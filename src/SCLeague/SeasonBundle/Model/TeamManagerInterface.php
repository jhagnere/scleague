<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 22/09/15
 * Time: 02:21
 */

namespace SCLeague\SeasonBundle\Model;


interface TeamManagerInterface
{

    /**
     * Return either the previous or the next division (or current) based on the manager
     * @return mixed
     */
    public function getDivision();

    /**
     * Create the new entities to persist in DB concerning the season
     *
     */
    public function manageTeamsForSeason();

}