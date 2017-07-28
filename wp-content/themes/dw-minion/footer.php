        </div>
      </div>
    </div>
    <footer id="colophon" class="site-footer" role="contentinfo">
      <div class="container">
        <script>
            (function(){
                var bp = document.createElement('script');
                var curProtocol = window.location.protocol.split(':')[0];
                if (curProtocol === 'https') {
                    bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';        
                } else {
                    bp.src = 'http://push.zhanzhang.baidu.com/push.js';
                }
                var s = document.getElementsByTagName("script")[0]; 
                s.parentNode.insertBefore(bp, s);
            })();
        </script>
        <div class="site-info">
          <?php printf( __( 'Powered by: %2$s.'), 'Wordpress', '<a href="http://wordpress.org/" rel="nofollow">Wordpress</a>' ); ?>
          <?php echo "&nbsp"?>
          <?php printf( __( 'Theme: %2$s.'), 'DW Minion', '<a href="http://www.designwall.com/" rel="nofollow">DW Minion</a>' ); ?>
          <?php echo "&nbsp"?>
          <?php esc_attr_e('Copyright ©', 'preference-lite'); ?>
          <?php esc_attr_e(date('Y')); ?>
          <a href="http://www.binsky.net/">Binsky</a>
          <?php esc_attr_e('. All rights reserved.', 'preference-lite'); ?>
          <?php echo "&nbsp"?>
          <?php do_action( 'dw_minion_credits' ); ?>
        </div>
      </div>
    </footer>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>