<?php
/**
 * Framework Component
 * @name      ALEX_CMS
 * @author    Alex Jurii <jurii@mail.ru>
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2016
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * A helper class that helps generate URL from routes.
 *
 * @author Leng Sheng Hong <darkredz@gmail.com>
 * @version $Id: DooUrlBuilder.php 1000 2009-08-4 11:17:22
 * @package doo.helper
 * @since 1.1
 */
class DooUrlBuilder {

    /**
     * Build URL based on a route Id.
     * @param string $id Id of the route
     * @param array $param Parameter values to build the route URL
     * @param bool $addAppUrl Add the APP_URL to the url
     * @return string URL of a route
     */
    public static function url($id, $param=null, $addAppUrl=false){
        $route = Doo::app()->route;
        $routename = null;
        foreach($route as $req=>$r){
            foreach($r as $rname=>$value){
                if(isset($value['id']) && $value['id']==$id){
                    $routename = $rname;
                    break;
                }
            }
        }

        if($addAppUrl)
            $routename = Doo::conf()->APP_URL . substr($routename,1);

        if($param!=null){
            foreach($param as $k=>$v){
                $routename = str_replace(':' . $k, $v, $routename);
            }
        }

        return $routename;
    }

    /**
     * Build URL based on a route Controller and Method.
     * @param string $controller Name of the Controller
     * @param string $method Name of the Action method
     * @param array $param Parameter values to build the route URL
     * @param bool $addAppUrl Add the APP_URL to the url
     * @return string URL of a route
     */
    public static function url2($controller, $method, $param=null, $addAppUrl=false){
        $route = Doo::app()->route;
        $routename = null;
        
        foreach($route as $req=>$r){            
            if(is_array($r)===false) continue;
            
            foreach($r as $rname=>$value){
                //normal routes                
                if(isset($value[0]) && $value[0]==$controller && $value[1]==$method){
                    $routename = $rname;
                    break;
                }
                else if($rname==='catchall'){
                    $catchallRoutes[] = $value;
                }
            }
            if(!empty($routename)) break;
        }                  
        
        if(empty($routename) && !empty($catchallRoutes)){
            // catchall routes
            foreach($catchallRoutes as $value){
                foreach($value as $rname2=>$value2){
                    if($value2[0]==$controller && $value2[1]==$method){                   
                        $routename = $rname2;
                        $catchall = true;
                        break;
                    }
                }
                if(!empty($routename)) break;
            }   
        }
                
        if($addAppUrl)
            $routename = Doo::conf()->APP_URL . substr($routename,1);

        if(isset($catchall)){
            if($param!=null){
                $totalDefinedKey = substr_count($routename, ':');
                
                if($totalDefinedKey > 0){
                    $i = 0;
                    foreach($param as $k=>$v){
                        $routename = str_replace(':' . $k, $v, $routename);   
                        unset($param[$k]);
                        $i++;
                        if($i === $totalDefinedKey) break;
                    }
                }

                if(!empty($param)){
                    $routename .= '/'. implode('/', $param);
                }
            }
        }
        else if($param!=null){
            foreach($param as $k=>$v){
                $routename = str_replace(':' . $k, $v, $routename);
            }                
        }

        return $routename;
    }
}
