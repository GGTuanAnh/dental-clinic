<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseAdminController extends Controller
{
    /**
     * Check if request is from HTMX
     */
    protected function isHtmxRequest()
    {
        return request()->header('HX-Request') === 'true';
    }

    /**
     * Return partial view if HTMX request, full view otherwise
     */
    protected function renderView($view, $data = [], $title = null, $pageTitle = null)
    {
        $viewData = array_merge($data, [
            'title' => $title,
            'pageTitle' => $pageTitle ?? $title,
        ]);

        if ($this->isHtmxRequest()) {
            $this->setHtmxHeaders($title);
            // Ưu tiên partial view nếu có
            $partialView = $view . '-partial';
            if (view()->exists($partialView)) {
                return view($partialView, $viewData);
            }
            return view($view, $viewData);
        }

        // Request thường: trả về layout đầy đủ
        $viewData['layout'] = 'layouts.admin-simple';
        return view($view, $viewData);
    }

    /**
     * Set response headers for HTMX
     */
    protected function setHtmxHeaders($title = null)
    {
        if ($title) {
                header('HX-Title: ' . $title);
        }
        
        // Trigger events for page transitions
            header('HX-Trigger: page-loaded');
    }
}