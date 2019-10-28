<?php

namespace TickTackk\XFRMModeratorActions\XFRM\Pub\Controller;

use XF\Mvc\ParameterBag;
use TickTackk\XFRMModeratorActions\XFRM\Entity\ResourceItem as ExtendedResourceItemEntity;
use XF\ControllerPlugin\ModeratorLog as ModeratorLogPlugin;
use XF\Mvc\Reply\Message as MessageReply;
use XF\Mvc\Reply\View as ViewReply;
use XF\Mvc\Reply\Exception as ExceptionReply;

/**
 * Class ResourceItem
 *
 * @package TickTackk\XFRMModeratorActions\XFRM\Pub\Controller
 */
class ResourceItem extends XFCP_ResourceItem
{
    /**
     * @param ParameterBag $parameterBag
     *
     * @return MessageReply|ViewReply
     * @throws ExceptionReply
     */
    public function actionModeratorActions(ParameterBag $parameterBag)
    {
        /** @var ExtendedResourceItemEntity $resourceItem */
        /** @noinspection PhpUndefinedFieldInspection */
        $resourceItem = $this->assertViewableResource($parameterBag->resource_id);

        if (!$resourceItem->canViewModeratorLogs($error))
        {
            throw $this->exception($this->noPermission($error));
        }

        $breadcrumbs = $resourceItem->getBreadcrumbs();
        $prefix = $this->app()->templater()->func('prefix', ['resource', $resourceItem, 'escaped']);
        $title = $prefix . $resourceItem->title;

        /** @var ModeratorLogPlugin $modLogPlugin */
        $modLogPlugin = $this->plugin('XF:ModeratorLog');
        return $modLogPlugin->actionModeratorActions(
            $resourceItem,
            ['resources/moderator-actions', $resourceItem],
            $title, $breadcrumbs
        );
    }
}