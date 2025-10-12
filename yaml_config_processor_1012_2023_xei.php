<?php
// 代码生成时间: 2025-10-12 20:23:53
class YamlConfigProcessor {

    /**
     * The path to the YAML configuration file.
     *
     * @var string
     */
    protected $filePath;

    /**
     * The parsed YAML configuration data.
     *
     * @var array
     */
    protected $configData;

    /**
     * Constructor to initialize the YAML file path.
     *
     * @param string $filePath
     */
    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    /**
     * Reads the YAML configuration file and parses its contents.
     *
     * @return array
     *
     * @throws Exception If the file cannot be read or parsed.
     */
    public function readConfig() {
        if (!file_exists($this->filePath)) {
            throw new Exception('YAML configuration file not found.');
        }

        $yamlContent = file_get_contents($this->filePath);

        return $this->parseYaml($yamlContent);
    }

    /**
     * Parses the YAML content using the Symfony YAML component.
     *
     * @param string $yamlContent
     *
     * @return array
     *
     * @throws Exception If the YAML content cannot be parsed.
     */
    protected function parseYaml($yamlContent) {
        try {
            $yaml = new Symfony\Component\Yaml\Yaml();
            $this->configData = $yaml->parse($yamlContent);

            return $this->configData;
        } catch (Exception $e) {
            throw new Exception('Error parsing YAML content: ' . $e->getMessage());
        }
    }

    /**
     * Retrieves the parsed YAML configuration data.
     *
     * @return array
     */
    public function getConfigData() {
        return $this->configData;
    }
}
