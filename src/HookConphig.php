<?php
/*
 Copyright 2016-present The arc-hook-conphig Authors. All Rights Reserved.

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 */

#
# Hookable arcanist configuration.
#
class HookConphig extends ArcanistConfiguration {

  # Post-workflow hooks
  public function didRunWorkflow($command, ArcanistWorkflow $workflow, $err) {
    if (!$err) {
      $workflowName = $workflow->getWorkflowName();

      if (!$workflow->requiresRepositoryAPI()) {
        return;
      }

      foreach (PhutilBootloader::getInstance()->getAllLibraries() as $library) {
        $libraryMap = PhutilBootloader::getInstance()->getLibraryMap($library);
        foreach ($libraryMap['class'] as $class => $path) {
          if (method_exists($class, 'hookType')) {
            if ($class::hookType() == "post-$workflowName") {
              $hook = new $class();
              $hook->doHook($workflow);
            }
          }
        }
      }
    }
  }
}

?>