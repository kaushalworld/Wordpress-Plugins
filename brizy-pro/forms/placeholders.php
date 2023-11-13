<?php


class BrizyPro_Forms_Placeholders
{
    public function __construct()
    {
        add_filter('brizy_form_email_to', [$this, 'replacePlaceholders'], 10, 3);
        add_filter('brizy_replay_to', [$this, 'replacePlaceholders'], 10, 3);
        add_filter('brizy_form_email_headers', [$this, 'replacePlaceholders'], 10, 3);
        add_filter('brizy_form_email_body', [$this, 'replacePlaceholders'], 10, 3);
        add_filter('brizy_form_email_subject', [$this, 'replacePlaceholders'], 10, 3);
        add_filter('brizy_form_placeholders', [$this, 'administratorsEmailPlaceholders'], 10, 3);
    }

    public function replacePlaceholders($data, $fields, $form)
    {
        if (is_array($data))
            $data = $this->replacePlaceholdersInArrayOfString($data, $fields, $form);
        if (is_string($data))
            $data = $this->replacePlaceholdersInString($data, $fields, $form);

        return $data;
    }

    private function replacePlaceholdersInString($content, $fields, $form)
    {
        $matches = array();
        preg_match_all("/(?<placeholder>{{\s*(?<placeholderName>.+?)\s*}})/ims", $content, $matches);

        if (count($matches['placeholderName'])) {
            foreach ($matches['placeholderName'] as $i => $placeholderName) {
                $value = $this->getValueForPlaceholder($placeholderName, $fields, $form);
                if ($value !== false) {
                    $content = str_replace($matches['placeholder'][$i], $value, $content);
                }
            }
        }
        return $content;
    }

    private function replacePlaceholdersInArrayOfString($strings, $fields, $form)
    {
        foreach ((array)$strings as $key => $string) {
            $strings[$key] = $this->replacePlaceholdersInString($string, $fields, $form);
        }

        return $strings;
    }

    private function getFieldBy($fields, $column, $value)
    {
        foreach ($fields as $field) {
            if ($field->{$column} === $value) {
                return $field;
            }
        }

        return null;
    }

    private function getValueFromFields($fields, $placeholderName)
    {
        $field = $this->getFieldBy($fields, 'label', $placeholderName);
        if ($field)
            return $field->value;

        return false;
    }

    private function getValueFromOtherPlaceholders($fields, $form, $placeholderName)
    {
        $placeholders = apply_filters('brizy_form_placeholders', [], $fields, $form);

        foreach ($placeholders as $map) {
            if ($map->name === $placeholderName) {
                return $map->value;
            }
        }

        return null;
    }


    private function getValueForPlaceholder($placeholderName, $fields, $form)
    {
        // try to get the value from fields
        $value = $this->getValueFromFields($fields, $placeholderName);
        if ($value) return $value;

        // try to get value from additional placeholders
        $value = $this->getValueFromOtherPlaceholders($fields, $form, $placeholderName);
        if ($value) return $value;

        return false;
    }

    /**
     * @param $placeholders
     * @param $fields
     * @param $form
     * @return array
     */
    public function administratorsEmailPlaceholders($placeholders, $fields, $form)
    {
        $users = get_users(['role__not_in' => ['Subscriber']]);

        foreach ($users as $user) {
            $placeholders['email_'.$user->data->user_login] = (object)['name' => $user->data->user_login, 'value' => $user->data->user_email];
            $placeholders['email_'.$user->data->user_nicename] = (object)['name' => $user->data->user_nicename, 'value' => $user->data->user_email];
            $placeholders['email_'.$user->data->display_name] = (object)['name' => $user->data->display_name, 'value' => $user->data->user_email];
        }

        return array_values($placeholders);
    }
}