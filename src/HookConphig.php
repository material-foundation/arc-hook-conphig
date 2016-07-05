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
  
  const HOOK_DIR = '.arc-hooks';

  # Post-workflow hooks
  public function didRunWorkflow($command, ArcanistWorkflow $workflow, $err) {
    if (!$err) {
      $workflowName = $workflow->getWorkflowName();

      if (!$workflow->requiresRepositoryAPI()) {
        return;
      }

      $dir = $workflow->getRepositoryAPI()->getPath().self::HOOK_DIR."/post-$workflowName";
      if (!file_exists($dir)) {
        return;
      }
      foreach (scandir($dir) as $path) {
        if (substr($path, 0, 1) == '.') {
          continue;
        }
        $subdir = "$dir/$path/src";
        foreach (scandir($subdir) as $subpath) {
          if (endsWith($subpath, 'ArcanistHook.php')) {
            $class = substr($subpath, 0, strlen($subpath) - 4);
            if (class_exists($class)) {
              $hook = new $class();
              $hook->doHook($workflow);
            }
          }
        }
      }
    }
  }
}

function endsWith($haystack, $needle) {
  return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

?>