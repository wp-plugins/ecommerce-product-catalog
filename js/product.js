jQuery(document).ready(function($) {
  $.ic = {
    /**
     * Implement a WordPress-link Hook System for Javascript 
     * TODO: Change 'tag' to 'args', allow number (priority), string (tag), object (priority+tag)
     */
    hooks: { action: {}, filter: {} },
    addAction: function( action, callable, tag ) {
      jQuery.ic.addHook( 'action', action, callable, tag );
    },
    addFilter: function( action, callable, tag ) {
      jQuery.ic.addHook( 'filter', action, callable, tag );
    },
    doAction: function( action, args ) {
      jQuery.ic.doHook( 'action', action, null, args );
    },
    applyFilters: function( action, value, args ) {
      return jQuery.ic.doHook( 'filter', action, value, args );
    },
    removeAction: function( action, tag ) {
      jQuery.ic.removeHook( 'action', action, tag );
    },
    removeFilter: function( action, tag ) {
      jQuery.ic.removeHook( 'filter', action, tag );
    },
    addHook: function( hookType, action, callable, tag ) {
      if ( undefined == jQuery.ic.hooks[hookType][action] ) {
        jQuery.ic.hooks[hookType][action] = [];
      }
      var hooks = jQuery.ic.hooks[hookType][action];
      if ( undefined == tag ) {
        tag = action + '_' + hooks.length;
      }
      jQuery.ic.hooks[hookType][action].push( { tag:tag, callable:callable } );
    },
    doHook: function( hookType, action, value, args ) {
      if ( undefined != jQuery.ic.hooks[hookType][action] ) {
        var hooks = jQuery.ic.hooks[hookType][action];
        for( var i=0; i<hooks.length; i++) {
          if ( 'action'==hookType ) {
            hooks[i].callable(args);
          } else {
            value = hooks[i].callable(value, args);
          }
        }
      }
      if ( 'filter'==hookType ) {
        return value;
      }
    },
    removeHook: function( hookType, action, tag ) {
      if ( undefined != jQuery.ic.hooks[hookType][action] ) {
        var hooks = jQuery.ic.hooks[hookType][action];
        for( var i=hooks.length-1; i>=0; i--) {
          if (undefined==tag||tag==hooks[i].tag)
            hooks.splice(i,1);
          }
        }
      }
  }
});