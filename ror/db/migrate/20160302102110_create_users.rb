class CreateUsers < ActiveRecord::Migration
  def change
    create_table :users do |t|
      t.string :name
      t.string :address
      t.string :mobilenumber
      t.string :email
      t.string :password

      t.timestamps null: false
    end
  end
end
