<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

/**
 * Interface representing basic mouse operations.
 */
interface WebDriverMouse {

  /**
   * @return WebDriverMouse
   */
  public function click(WebDriverCoordinates $where);

  /**
   * @return WebDriverMouse
   */
  public function contextClick(WebDriverCoordinates $where);

  /**
   * @return WebDriverMouse
   */
  public function doubleClick(WebDriverCoordinates $where);

  /**
   * @return WebDriverMouse
   */
  public function mouseDown(WebDriverCoordinates $where);

  /**
   * @return WebDriverMouse
   */
  public function mouseMove(WebDriverCoordinates $where,
                            $x_offset = null,
                            $y_offset = null);

  /**
   * @return WebDriverMouse
   */
  public function mouseUp(WebDriverCoordinates $where);
}
