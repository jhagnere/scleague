<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 22/09/15
 * Time: 02:21
 */

namespace SCLeague\SeasonBundle\Model;


use Doctrine\Common\Collections\ArrayCollection;
use SCLeague\SeasonBundle\Entity\Division;
use SCLeague\SeasonBundle\Entity\Season;

class TeamStayManager implements TeamManagerInterface
{

    /**
     * TeamStayManager constructor.
     * @param ArrayCollection $teams
     * @param Division $division
     */
    public function __construct(ArrayCollection $teams,Division $division)
    {
    }


    /**
     * Create the new entities to persist in DB concerning the season
     *
     */
    public function manageTeamsForSeason(Season $season)
    {

    }
}