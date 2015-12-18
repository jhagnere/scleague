<?php

namespace SCLeague\SeasonBundle\Model;

interface SeasonManagerInterface
{

   /**
     * @param $id
     * @return mixed
    *
     */
    public function launchSeason($id);

    public function closeSeason($id);


}