<?php

namespace TickTackk\XFRMModeratorActions\XFRM\Entity;

/**
 * Class ResourceItem
 *
 * @package TickTackk\XFRMModeratorActions\XFRM\Entity
 */
class ResourceItem extends XFCP_ResourceItem
{
    /**
     * @param null $error
     *
     * @return bool
     */
    public function canViewModeratorLogs(/** @noinspection PhpUnusedParameterInspection */&$error = null) : bool
    {
        $visitor = \XF::visitor();
        if (!$visitor->user_id)
        {
            return false;
        }

        return $this->hasPermission('viewModeratorActions');
    }
}