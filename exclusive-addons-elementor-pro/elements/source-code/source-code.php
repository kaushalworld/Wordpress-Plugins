<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;

class Source_Code extends Widget_Base {

    public function get_name() {
        return 'exad-source-code';
    }

    public function get_title() {
        return esc_html__( 'Source Code', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-source-code';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_script_depends() {
        return [ 'exad-prism' ];
    }

    public function get_code_type() {
        return [
            'markup'            => __( 'HTML', 'exclusive-addons-elementor-pro' ),
            'css'               => __( 'CSS', 'exclusive-addons-elementor-pro' ),
            'php'               => __( 'PHP', 'exclusive-addons-elementor-pro' ),
            'javascript'        => __( 'JavaScript', 'exclusive-addons-elementor-pro' ),
            'actionscript'      => __( 'ActionScript', 'exclusive-addons-elementor-pro' ),
            'apacheconf'        => __( 'Apache Configuration', 'exclusive-addons-elementor-pro' ),
            'applescript'       => __( 'AppleScript', 'exclusive-addons-elementor-pro' ),
            'arduino'           => __( 'Arduino', 'exclusive-addons-elementor-pro' ),
            'aspnet'            => __( 'ASP.NET(C#)', 'exclusive-addons-elementor-pro' ),
            'bash'              => __( 'Bash', 'exclusive-addons-elementor-pro' ),
            'basic'             => __( 'BASIC', 'exclusive-addons-elementor-pro' ),
            'c'                 => __( 'C', 'exclusive-addons-elementor-pro' ),
            'csharp'            => __( 'C#', 'exclusive-addons-elementor-pro' ),
            'cpp'               => __( 'C++', 'exclusive-addons-elementor-pro' ),
            'clike'             => __( 'Clike', 'exclusive-addons-elementor-pro' ),
            'clojure'           => __( 'Clojure', 'exclusive-addons-elementor-pro' ),
            'coffeescript'      => __( 'CoffeeScript', 'exclusive-addons-elementor-pro' ),
            'dart'              => __( 'Dart', 'exclusive-addons-elementor-pro' ),
            'django'            => __( 'Django/Jinja2', 'exclusive-addons-elementor-pro' ),
            'docker'            => __( 'Docker', 'exclusive-addons-elementor-pro' ),
            'elixir'            => __( 'Elixir', 'exclusive-addons-elementor-pro' ),
            'erlang'            => __( 'Erlang', 'exclusive-addons-elementor-pro' ),
            'git'               => __( 'Git', 'exclusive-addons-elementor-pro' ),
            'go'                => __( 'Go', 'exclusive-addons-elementor-pro' ),
            'graphql'           => __( 'GraphQL', 'exclusive-addons-elementor-pro' ),
            'haml'              => __( 'Haml', 'exclusive-addons-elementor-pro' ),
            'haskell'           => __( 'Haskell', 'exclusive-addons-elementor-pro' ),
            'http'              => __( 'HTTP', 'exclusive-addons-elementor-pro' ),
            'hpkp'              => __( 'HTTP Public-Key-Pins', 'exclusive-addons-elementor-pro' ),
            'hsts'              => __( 'HTTP Strict-Transport-Security', 'exclusive-addons-elementor-pro' ),
            'java'              => __( 'Java', 'exclusive-addons-elementor-pro' ),
            'javadoc'           => __( 'JavaDoc', 'exclusive-addons-elementor-pro' ),
            'javadoclike'       => __( 'JavaDoc-like', 'exclusive-addons-elementor-pro' ),
            'javastacktrace'    => __( 'Java stack trace', 'exclusive-addons-elementor-pro' ),
            'jsdoc'             => __( 'JSDoc', 'exclusive-addons-elementor-pro' ),
            'js-extras'         => __( 'JS Extras', 'exclusive-addons-elementor-pro' ),
            'js-templates'      => __( 'JS Templates', 'exclusive-addons-elementor-pro' ),
            'json'              => __( 'JSON', 'exclusive-addons-elementor-pro' ),
            'jsonp'             => __( 'JSONP', 'exclusive-addons-elementor-pro' ),
            'json5'             => __( 'JSON5', 'exclusive-addons-elementor-pro' ),
            'kotlin'            => __( 'Kotlin', 'exclusive-addons-elementor-pro' ),
            'less'              => __( 'Less', 'exclusive-addons-elementor-pro' ),
            'lisp'              => __( 'Lisp', 'exclusive-addons-elementor-pro' ),
            'markdown'          => __( 'Markdown', 'exclusive-addons-elementor-pro' ),
            'markup-templating' => __( 'Markup templating', 'exclusive-addons-elementor-pro' ),
            'matlab'            => __( 'MATLAB', 'exclusive-addons-elementor-pro' ),
            'nginx'             => __( 'nginx', 'exclusive-addons-elementor-pro' ),
            'nix'               => __( 'Nix', 'exclusive-addons-elementor-pro' ),
            'objectivec'        => __( 'Objective-C', 'exclusive-addons-elementor-pro' ),
            'perl'              => __( 'Perl', 'exclusive-addons-elementor-pro' ),
            'phpdoc'            => __( 'PHPDoc', 'exclusive-addons-elementor-pro' ),
            'php-extras'        => __( 'PHP Extras', 'exclusive-addons-elementor-pro' ),
            'plsql'             => __( 'PL/SQL', 'exclusive-addons-elementor-pro' ),
            'powershell'        => __( 'PowerShell', 'exclusive-addons-elementor-pro' ),
            'python'            => __( 'Python', 'exclusive-addons-elementor-pro' ),
            'r'                 => __( 'R', 'exclusive-addons-elementor-pro' ),
            'jsx'               => __( 'React JSX', 'exclusive-addons-elementor-pro' ),
            'tsx'               => __( 'React TSX', 'exclusive-addons-elementor-pro' ),
            'regex'             => __( 'Regex', 'exclusive-addons-elementor-pro' ),
            'rest'              => __( 'reST (reStructuredText)', 'exclusive-addons-elementor-pro' ),
            'ruby'              => __( 'Ruby', 'exclusive-addons-elementor-pro' ),
            'sass'              => __( 'Sass (Sass)', 'exclusive-addons-elementor-pro' ),
            'scss'              => __( 'Sass (Scss)', 'exclusive-addons-elementor-pro' ),
            'scala'             => __( 'Scala', 'exclusive-addons-elementor-pro' ),
            'sql'               => __( 'SQL', 'exclusive-addons-elementor-pro' ),
            'stylus'            => __( 'Stylus', 'exclusive-addons-elementor-pro' ),
            'swift'             => __( 'Swift', 'exclusive-addons-elementor-pro' ),
            'twig'              => __( 'Twig', 'exclusive-addons-elementor-pro' ),
            'typescript'        => __( 'TypeScript', 'exclusive-addons-elementor-pro' ),
            'vbnet'             => __( 'VB.Net', 'exclusive-addons-elementor-pro' ),
            'visual-basic'      => __( 'Visual Basic', 'exclusive-addons-elementor-pro' ),
            'wasm'              => __( 'WebAssembly', 'exclusive-addons-elementor-pro' ),
            'wiki'              => __( 'Wiki markup', 'exclusive-addons-elementor-pro' ),
            'xquery'            => __( 'XQuery', 'exclusive-addons-elementor-pro' ),
            'yaml'              => __( 'YAML', 'exclusive-addons-elementor-pro' )
        ];
    }

    protected function register_controls() {
        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'exad_source_code_control_section',
            [
                'label' => __( 'Source Code', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_source_code_type',
            [
                'label'   => __( 'Code', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'markup',
                'options' => $this->get_code_type()
            ]
        );

        $this->add_control(
            'exad_source_code_theme',
            [
                'label'       => __('Theme', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'prism',
                'options'     => [
                    'prism'                => __( 'Default', 'exclusive-addons-elementor-pro' ),
                    'prism-dark'           => __( 'Dark', 'exclusive-addons-elementor-pro' ),
                    'prism-funky'          => __( 'Funky', 'exclusive-addons-elementor-pro' ),
                    'prism-okaidia'        => __( 'Okaidia', 'exclusive-addons-elementor-pro' ),
                    'prism-twilight'       => __( 'Twilight', 'exclusive-addons-elementor-pro' ),
                    'prism-coy'            => __( 'Coy', 'exclusive-addons-elementor-pro' ),
                    'prism-solarizedlight' => __( 'Solarized light', 'exclusive-addons-elementor-pro' ),
                    'prism-tomorrow'       => __( 'Tomorrow', 'exclusive-addons-elementor-pro' ),
                    'custom'               => __( 'Custom', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_source_code',
            [
                'label'       => __( 'Source Code', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::CODE,
                'rows'        => 30,
                'default'     => __( '<p class="your-exclusive-class">Exclusive Addons For Elementor Source Code Is written here.</p>' ),
                'placeholder' => __( 'Paste your source code here.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_source_code_enable_copy_button',
            [
                'label'        => esc_html__( 'Enable Copy Button', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_source_code_enable_line_number',
            [
                'label'        => esc_html__( 'Enable Line Number', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_source_code_button_visibility_type',
            [
                'label'     => esc_html__( 'Button Visibility', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'always',
                'options'   => [
                    'always'   => esc_html__( 'Always',   'exclusive-addons-elementor-pro' ),
                    'on-hover' => esc_html__( 'On Hover', 'exclusive-addons-elementor-pro' )
                ],
                'condition' => [
                    'exad_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_source_code_button_position_type',
            [
                'label'     => esc_html__( 'Button Position', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'top-right',
                'options'   => [
                    'top-right'    => esc_html__( 'Top Right Corner',   'exclusive-addons-elementor-pro' ),
                    'bottom-right' => esc_html__( 'Bottom Right Corner', 'exclusive-addons-elementor-pro' )
                ],
                'condition' => [
                    'exad_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_source_code_copy_btn_text', [
                'label'     => esc_html__( 'Copy Button Text', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Copy to clipboard', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_source_code_after_copied_btn_text', [
                'label'     => esc_html__( 'After Copied Button Text', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Copied', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_source_code_container_style',
            [
                'label'     => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_source_code_container_height',
            [
                'label'        => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => ['px', '%'],
                'range'        => [
                    'px'       => [
                        'min'  => 100,
                        'max'  => apply_filters( 'exad_source_code_container_height_max_value', 1200 ),
                        'step' => 5
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-source-code pre' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_source_code_container_background_color',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'fields_options'  => [
                    'background'  => [
                        'default' => 'classic'
                    ],
                    'color'       => [
                        'default' => '#f5f2f0'
                    ]
                ],
                'selector' => '{{WRAPPER}} .custom :not(pre) > code[class*="language-"], {{WRAPPER}} .custom pre[class*="language-"]',
                'condition' => [
                    'exad_source_code_theme' => 'custom'
                ]
			]
        );

        $this->add_responsive_control(
            'exad_source_code_container_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => '10',
                    'right'  => '20',
                    'bottom' => '10',
                    'left'   => '80'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-source-code pre' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_source_code_container_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-source-code pre' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_source_code_container_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .custom :not(pre) > code[class*="language-"], {{WRAPPER}} .custom pre[class*="language-"]  .language-markup',
                'condition' => [
                    'exad_source_code_theme' => 'custom'
                ]
			]
		);

        $this->add_control(
			'exad_source_code_container_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom :not(pre) > code[class*="language-"], {{WRAPPER}} .custom pre[class*="language-"]  .language-markup' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'exad_source_code_theme' => 'custom'
                ]
			]
        );
        
        $this->add_control(
			'exad_source_code_container_line_number_color',
			[
				'label' => __( 'Line Number Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-source-code .line-numbers-rows > span:before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .exad-source-code .line-numbers .line-numbers-rows' => 'border-right: 1px solid {{VALUE}};',
                ],
                'condition' => [
                    'exad_source_code_theme' => 'custom'
                ]
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_source_code_container_border',
                'selector' => '{{WRAPPER}} .exad-source-code pre'
            ]
        );

        $this->add_responsive_control(
            'exad_source_code_container_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-source-code pre' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_source_code_button_style',
            [
                'label'     => esc_html__( 'Button', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'             => 'exad_source_code_button_text_typography',
                'fields_options'   => [
                    'font_size'    => [
                        'default'  => [
                            'unit' => 'px',
                            'size' => 13
                        ]
                    ]
                ],
                'selector'         => '{{WRAPPER}} .exad-source-code pre .exad-copy-button'
            ]
        );

        $this->add_control(
            'exad_source_code_button_color',
            [
                'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-source-code pre .exad-copy-button' => 'color: {{VALUE}};'
                ]   
            ]
        );

        $this->add_control(
            'exad_source_code_button_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-source-code pre .exad-copy-button' => 'background-color: {{VALUE}};'
                ]   
            ]
        );

        $this->add_responsive_control(
            'exad_source_code_button_padding',
            [
                'label'        => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '6',
                    'right'    => '25',
                    'bottom'   => '6',
                    'left'     => '25',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-source-code pre .exad-copy-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_source_code_button_border',
                'selector' => '{{WRAPPER}} .exad-source-code pre .exad-copy-button'
            ]
        );

        $this->add_responsive_control(
            'exad_source_code_button_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-source-code pre .exad-copy-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings         = $this->get_settings_for_display();
        $exad_source_code = $settings['exad_source_code'];
        $line_number = 'disable-line-numbers';

        if( 'yes' === $settings['exad_source_code_enable_line_number'] ) :
            $line_number = 'line-numbers';
        endif;

        $this->add_render_attribute( 'exad_source_code_wrapper', 'class', 'exad-source-code' );
        $this->add_render_attribute( 'exad_source_code_wrapper', 'class', esc_attr( $settings['exad_source_code_theme'] ) );
        $this->add_render_attribute( 'exad_source_code_wrapper', 'data-lng-type', esc_attr( $settings['exad_source_code_type'] ) );

        if( 'yes' === $settings['exad_source_code_enable_copy_button'] && ! empty( $settings['exad_source_code_after_copied_btn_text'] ) ) :
            $this->add_render_attribute( 'exad_source_code_wrapper', 'data-after-copied-btn-text', esc_attr( $settings['exad_source_code_after_copied_btn_text'] ) );
            $this->add_render_attribute( 'exad_source_code_wrapper', 'class', 'visibility-'.esc_attr( $settings['exad_source_code_button_visibility_type'] ) );
            $this->add_render_attribute( 'exad_source_code_wrapper', 'class', 'position-'.esc_attr( $settings['exad_source_code_button_position_type'] ) );
        endif;

        $this->add_render_attribute( 'exad_source_code', 'class', 'language-' . $settings['exad_source_code_type'] );

        if ( $exad_source_code ) : ?>
            <div <?php $this->print_render_attribute_string('exad_source_code_wrapper'); ?>>
                <pre class="<?php echo esc_attr( $line_number ); ?>">
                    <?php
                    if( 'yes' === $settings['exad_source_code_enable_copy_button'] && ! empty( $settings['exad_source_code_after_copied_btn_text'] ) ) : ?>
                        <button class="exad-copy-button"><?php echo esc_html( $settings['exad_source_code_copy_btn_text'] ); ?></button>
                    <?php endif; ?>
                    <code <?php $this->print_render_attribute_string('exad_source_code'); ?>>
                        <?php echo esc_html( $exad_source_code ); ?>
                    </code>
                </pre>
            </div>
        <?php    
        endif;
    }
}

