terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 3.37.0"
    }
  }
}
provider "aws" {
  region     = "us-west-2"
  access_key = "AKIASDC5XRLESZCTU7P7"
  secret_key = "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"
}
resource "aws_default_vpc" "default_vpc" {

}
resource "aws_security_group" "test" {
  name        = "allow_ssh"
  description = "Allow ssh inbound traffic"

  # using default VPC
  vpc_id = aws_default_vpc.default_vpc.id

  ingress {
    description = "TLS from VPC"

    # we should allow incoming and outoging
    # TCP packets
    from_port = 22
    to_port   = 22
    protocol  = "tcp"

    # allow all traffic
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "allow_ssh"
  }
}
resource "aws_instance" "test" {
  ami           = var.ami_id
  instance_type = "t2.micro"

  # refering security group created earlier
  security_groups = [aws_security_group.test.name]

  tags = var.tags
}
variable "ami_id" {

  # I am using amazon linux image
  default = "ami-0ca285d4c2cda3300"
}

variable "tags" {
  type    = map(string)
  default = {
    "name" = "test"
  }
}
