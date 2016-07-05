# arc-hook-conphig

arc-hook-conphig is a hookable configuration engine for use with
[Phabricator](http://phabricator.org)'s `arc` command line tool.

## Features

Create hooks to customize your workflows.

## Supported hooks

The following hooks have been tested thus far:

- post-`arc diff`

## Installation

### Project-specific

Add this repository as a git submodule.

    git submodule init
    git submodule add <url for this repo>

Your `.arcconfig` should list `arc-hook-conphig` in the `load` configuration:

    {
      "load": [
        "path/to/arc-hook-conphig"
      ]
    }

### Global

Clone this repository to the same directory where `arcanist` and
`libphutil` are globally located. Your directory structure will
look like so:

    arcanist/
    libphutil/
    arc-hook-conphig/

Your `.arcconfig` should list `arc-hook-conphig` in the `load`
configuration (without a path):

    {
      "load": [
        "arc-hook-conphig"
      ]
    }

## Usage

Create a `.arc-hooks` directory in the root of your project. This directory will contain all of your
hooks.

Hooks go in sub-directories, organized by type of workflow. For example, `.arc-hooks/post-diff/`
hooks will be executed after the `arc diff` operation has completed.

    mkdir -p .arc-hooks/post-diff/

To create a hook, create a sub-directory for your hook. For example:
`.arc-hooks/post-diff/github-issues`. This sub-directory should be structured like a typical arc
library (use `arc liberate` to populate one).

Here's one possible folder hierarchy:

    .arc-hooks/
      post-diff/
        github-issues/
          src/
            MyCustomArcanistHook.php
          __phutil_library_init__.php
          __phutil_library_map__.php

Finally, load the hook in your `.arcconfig`:

    {
      "load": [
        ".arc-hooks/post-diff/arc-hook-github-issues"
      ]
    }

Any classes located in the library's `src/` directory ending with 'ArcanistHook' will be loaded and
executed.

## License

Licensed under the Apache 2.0 license. See LICENSE for details.