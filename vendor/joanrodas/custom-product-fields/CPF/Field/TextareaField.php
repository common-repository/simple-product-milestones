<?php

namespace CPF\Field;

class TextareaField extends Field
{
    private $height = '10rem';

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
        $value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<textarea class="short" style="<?= $this->height ? 'height:'.$this->height.';' : 'height:10rem;' ?>" name="<?= $key ?>" id="<?= $key ?>" placeholder="" rows="4" cols="20"><?= $value ?></textarea>
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='')
	{
		$key = $parent . '_' . $this->slug;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<textarea x-cloak class="short" style="<?= $this->height ? 'height:' . $this->height . ';' : 'height: 10rem;' ?>" name="<?= $key . '[]' ?>" id="<?= $key ?>" placeholder rows="4" cols="20" x-text="entries[tab] ? entries[tab]['<?= $key ?>'] : '<?= $this->default_value ?>'"></textarea>
		</p>
		<?php echo ob_get_clean();
	}

    public function height($height)
	{
		$this->height = sanitize_text_field($height);
		return $this;
	}

}
