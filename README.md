Console Command Chaining
========================

A Symfony bundle that implements command chaining functionality. Other Symfony bundles in the application may register their console commands to be members of a command chain. When a user runs the main command in a chain, all other commands registered in this chain should be executed as well. Commands registered as chain members can no longer be executed on their own.

For more information, please visit the [original requirements here](https://github.com/mbessolov/test-tasks/blob/master/7.md)
